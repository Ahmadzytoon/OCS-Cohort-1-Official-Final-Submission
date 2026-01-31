<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Models\AvailabilitySlot;
use App\Models\Booking;
use App\Models\User;
use App\Models\ProviderProfile;
use App\Models\ProviderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $bookings = Booking::query()
            ->where('customer_user_id', $userId)
            ->with([
                'provider:id,name',
                'category:id,code,name',
                'slot:id,start_time,end_time',
                'payment',
            ])
            ->orderByDesc('id')
            ->paginate(10);

        $statusMap = [
            'pending' => 'Pending',
            'accepted' => 'Confirmed',
            'completed' => 'Completed',
            'rejected' => 'Cancelled',
        ];

        return view('seeker.pages.bookings', compact('bookings', 'statusMap'));
    }

    public function show(Booking $booking)
    {
        if ($booking->customer_user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load([
            'provider:id,name',
            'category:id,code,name',
            'slot:id,start_time,end_time',
            'payment',
            'review',
        ]);

        return view('seeker.pages.booking-details', compact('booking'));
    }

    public function review(Request $request, Booking $booking)
    {
        if ($booking->customer_user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->status !== 'completed') {
            return back()->withErrors(['review' => 'You can only review completed bookings.']);
        }

        if ($booking->review) {
            return back()->withErrors(['review' => 'You already reviewed this booking.']);
        }

        $data = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        \App\Models\Review::create([
            'booking_id' => $booking->id,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
        ]);

        $ratings = \App\Models\Review::query()
            ->whereHas('booking', fn ($q) => $q->where('provider_user_id', $booking->provider_user_id))
            ->pluck('rating');

        $count = $ratings->count();
        $avg = $count ? round($ratings->average(), 2) : 0.00;

        \App\Models\ProviderProfile::where('user_id', $booking->provider_user_id)->update([
            'avg_rating' => $avg,
            'rating_count' => $count,
        ]);

        return back()->with('success', 'Thanks for your review!');
    }

    public function payForm(Booking $booking)
    {
        if ($booking->customer_user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load(['provider:id,name', 'category:id,code,name', 'payment']);

        if ($booking->status !== 'accepted') {
            return redirect()
                ->route('seeker.bookings.show', $booking)
                ->withErrors(['payment' => 'Booking must be accepted before payment.']);
        }

        if ($booking->payment && $booking->payment->payment_status === 'paid') {
            return redirect()
                ->route('seeker.bookings.show', $booking)
                ->with('success', 'Payment already completed.');
        }

        return view('seeker.pages.payment', compact('booking'));
    }

    public function pay(Request $request, Booking $booking)
    {
        if ($booking->customer_user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->status !== 'accepted') {
            return back()->withErrors(['payment' => 'Booking must be accepted before payment.']);
        }

        $payment = $booking->payment;

        if ($payment && $payment->payment_status === 'paid') {
            return back()->with('success', 'Payment already completed.');
        }

        $currentYear = (int) now()->year;

        $validated = $request->validate([
            'card_name' => ['required', 'string', 'max:100'],
            'card_number' => ['required', 'digits_between:12,19'],
            'exp_month' => ['required', 'integer', 'between:1,12'],
            'exp_year' => ['required', 'integer', 'min:'.$currentYear, 'max:'.($currentYear + 15)],
            'cvv' => ['required', 'digits_between:3,4'],
        ]);

        if ((int) $validated['exp_year'] === $currentYear && (int) $validated['exp_month'] < (int) now()->month) {
            return back()
                ->withErrors(['exp_month' => 'Card expiry month is in the past.'])
                ->withInput();
        }

        \App\Models\Payment::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]
        );

        return redirect()
            ->route('seeker.bookings.show', $booking)
            ->with('success', 'Payment completed successfully.');
    }

    public function create(int $providerUserId)
    {
        $provider = ProviderProfile::query()
            ->where('user_id', $providerUserId)
            ->whereHas('user', function ($u) {
                $u->where('role', User::ROLE_PROVIDER)
                    ->where('status', User::STATUS_ACTIVE);
            })
            ->with([
                'user:id,name',
                'services' => function ($q) {
                    $q->with(['category:id,code,name', 'optionPricings.serviceOption:id,name,pricing_type,service_category_id']);
                },
                'availabilitySlots' => function ($q) {
                    $q->where('is_booked', false)->orderBy('start_time');
                },
            ])
            ->firstOrFail();

        $services = $provider->services ?? collect();
        $slots = $provider->availabilitySlots ?? collect();

        $services->each(function ($service) {
        $filtered = $service->optionPricings
            ->filter(function ($pricing) use ($service) {
                $option = $pricing->serviceOption;

                return $option && (int) $option->service_category_id === (int) $service->service_category_id;
            })
            ->values();

            $service->setRelation('optionPricings', $filtered);
        });


        return view('seeker.pages.checkout', compact('provider', 'services', 'slots'));
    }

    public function store(Request $request, int $providerUserId)
    {
        $data = $request->validate([
            'service_category_id' => ['required', 'integer'],
            'availability_segments' => ['required', 'array', 'min:1'],
            'service_address' => ['required', 'string', 'max:255'],
            'zip_code' => ['required', 'string', 'max:10'],
            'customer_note' => ['nullable', 'string', 'max:1000'],
            'options' => ['array'],
            'options.*' => ['integer'],
        ]);

        $providerService = ProviderService::query()
            ->where('provider_user_id', $providerUserId)
            ->where('service_category_id', $data['service_category_id'])
            ->with('optionPricings.serviceOption')
            ->first();

        if (!$providerService) {
            return back()->withErrors(['service_category_id' => 'Selected service is not available.'])->withInput();
        }

        $segments = collect($data['availability_segments'])
            ->map(function ($value) {
                $parts = explode('|', $value, 3);
                if (count($parts) !== 3) {
                    return null;
                }
                return [
                    'slot_id' => (int) $parts[0],
                    'start' => $parts[1],
                    'end' => $parts[2],
                ];
            })
            ->filter()
            ->unique(function ($seg) {
                return $seg['slot_id'].'|'.$seg['start'].'|'.$seg['end'];
            })
            ->values();

        if ($segments->isEmpty()) {
            return back()->withErrors(['availability_segments' => 'Select at least one time segment.'])->withInput();
        }

        // Get all unique slot IDs from selected segments
        $slotIds = $segments->pluck('slot_id')->unique()->values();

        // Validate all selected slots exist and are available
        $slots = AvailabilitySlot::query()
            ->whereIn('id', $slotIds)
            ->where('provider_user_id', $providerUserId)
            ->where('service_category_id', $data['service_category_id'])
            ->where('is_booked', false)
            ->get()
            ->keyBy('id');

        if ($slots->count() !== $slotIds->count()) {
            return back()->withErrors(['availability_segments' => 'One or more selected time slots are no longer available.'])->withInput();
        }

        $hourlyRate = (float) $providerService->hourly_rate;

        // Validate and process segments grouped by slot
        $segmentsBySlot = $segments->groupBy('slot_id');
        $allIntervals = collect();

        foreach ($segmentsBySlot as $slotId => $slotSegments) {
            $slot = $slots->get($slotId);
            
            $slotStart = Carbon::parse($slot->start_time);
            $slotEnd = Carbon::parse($slot->end_time);

            if ($slotEnd->lessThanOrEqualTo($slotStart)) {
                return back()
                    ->withErrors(['availability_segments' => 'One of the selected time slots is invalid.'])
                    ->withInput();
            }

            foreach ($slotSegments as $segment) {
                $segStart = Carbon::parse($segment['start']);
                $segEnd = Carbon::parse($segment['end']);

                if ($segEnd->lessThanOrEqualTo($segStart)) {
                    return back()
                        ->withErrors(['availability_segments' => 'Invalid time selection. End time must be after start time.'])
                        ->withInput();
                }

                if ($segStart->lt($slotStart) || $segEnd->gt($slotEnd)) {
                    return back()
                        ->withErrors(['availability_segments' => 'Selected time is outside the available slot.'])
                        ->withInput();
                }

                $allIntervals->push([
                    'slot_id' => $slotId,
                    'start' => $segStart,
                    'end' => $segEnd,
                ]);
            }
        }

        // Calculate total hours from all intervals
        $totalHours = $allIntervals->sum(function ($interval) {
            return $interval['start']->diffInHours($interval['end'], true);
        });

        $baseCost = $hourlyRate * $totalHours;

        $optionPriceMap = $providerService->optionPricings
            ->filter(function ($pricing) use ($data) {
                return (int) optional($pricing->serviceOption)->service_category_id === (int) $data['service_category_id'];
            })
            ->keyBy('service_option_id');

        $selectedOptions = collect($data['options'] ?? [])
            ->map(fn ($id) => (int) $id)
            ->filter(fn ($id) => $optionPriceMap->has($id))
            ->unique()
            ->values();

        $optionsCost = $selectedOptions->sum(function ($id) use ($optionPriceMap) {
            return (float) $optionPriceMap[$id]->price;
        });

        $totalCost = $baseCost + $optionsCost;

        $booking = DB::transaction(function () use ($data, $providerUserId, $hourlyRate, $selectedOptions, $optionPriceMap, $segmentsBySlot, $slots, $allIntervals) {
            $bookedSlotIds = [];

            // Process each slot separately
            foreach ($segmentsBySlot as $slotId => $slotSegments) {
                $slot = $slots->get($slotId);
                $slotStart = Carbon::parse($slot->start_time);
                $slotEnd = Carbon::parse($slot->end_time);

                // Get intervals for this slot and sort them
                $intervals = $slotSegments->map(function ($seg) {
                    return [
                        'start' => Carbon::parse($seg['start']),
                        'end' => Carbon::parse($seg['end']),
                    ];
                })->sortBy('start')->values();

                // Merge overlapping or contiguous intervals
                $merged = collect();
                foreach ($intervals as $interval) {
                    if ($merged->isEmpty()) {
                        $merged->push($interval);
                        continue;
                    }
                    $last = $merged->last();
                    if ($interval['start']->lte($last['end'])) {
                        $last['end'] = $interval['end']->gt($last['end']) ? $interval['end'] : $last['end'];
                        $merged[$merged->count() - 1] = $last;
                    } else {
                        $merged->push($interval);
                    }
                }

                // Calculate free segments
                $freeSegments = collect();
                $cursor = $slotStart->copy();

                foreach ($merged as $interval) {
                    if ($cursor->lt($interval['start'])) {
                        $freeSegments->push([
                            'start' => $cursor->copy(),
                            'end' => $interval['start']->copy(),
                        ]);
                    }
                    $cursor = $interval['end']->copy();
                }

                if ($cursor->lt($slotEnd)) {
                    $freeSegments->push([
                        'start' => $cursor->copy(),
                        'end' => $slotEnd->copy(),
                    ]);
                }

                // Create booked slots
                foreach ($merged as $interval) {
                    $bookedSlotIds[] = AvailabilitySlot::create([
                        'provider_user_id' => $slot->provider_user_id,
                        'service_category_id' => $slot->service_category_id,
                        'start_time' => $interval['start']->toDateTimeString(),
                        'end_time' => $interval['end']->toDateTimeString(),
                        'is_booked' => true,
                    ])->id;
                }

                // Create free slots
                foreach ($freeSegments as $segment) {
                    AvailabilitySlot::create([
                        'provider_user_id' => $slot->provider_user_id,
                        'service_category_id' => $slot->service_category_id,
                        'start_time' => $segment['start']->toDateTimeString(),
                        'end_time' => $segment['end']->toDateTimeString(),
                        'is_booked' => false,
                    ]);
                }

                // Delete the original slot
                $slot->delete();
            }

            $totalHours = $allIntervals->sum(function ($interval) {
                return $interval['start']->diffInHours($interval['end'], true);
            });

            $baseCost = $hourlyRate * $totalHours;
            $optionsCost = $selectedOptions->sum(function ($id) use ($optionPriceMap) {
                return (float) $optionPriceMap[$id]->price;
            });
            $totalCost = $baseCost + $optionsCost;

            $booking = Booking::create([
                'customer_user_id' => auth()->id(),
                'provider_user_id' => $providerUserId,
                'service_category_id' => $data['service_category_id'],
                'availability_slot_id' => $bookedSlotIds[0] ?? null,
                'hours' => $totalHours,
                'service_address' => $data['service_address'],
                'zip_code' => $data['zip_code'],
                'customer_note' => $data['customer_note'] ?? null,
                'hourly_rate' => $hourlyRate,
                'base_cost' => $baseCost,
                'options_cost' => $optionsCost,
                'total_cost' => $totalCost,
                'status' => 'pending',
            ]);

            if ($selectedOptions->isNotEmpty()) {
                foreach ($selectedOptions as $optionId) {
                    $pricing = $optionPriceMap[$optionId];
                    \App\Models\BookingOption::create([
                        'booking_id' => $booking->id,
                        'service_option_id' => $optionId,
                        'option_name' => $pricing->serviceOption?->name ?? 'Option',
                        'option_price' => $pricing->price,
                    ]);
                }
            }

            return $booking;
        });

        return redirect()
            ->route('seeker.bookings.show', $booking)
            ->with('success', 'Booking created. Status is pending.');
    }
}
