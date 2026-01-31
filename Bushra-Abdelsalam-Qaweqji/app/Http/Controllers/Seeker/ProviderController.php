<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Models\AvailabilitySlot;
use App\Models\Booking;
use App\Models\ProviderProfile;
use App\Models\ProviderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::query()
            ->where('customer_user_id', auth()->id())
            ->with([
                'provider:id,name',
                'category:id,code,name',
                'slot:id,start_time,end_time',
                'payment',
            ])
            ->orderByDesc('id')
            ->paginate(10);

        return view('seeker.pages.bookings', compact('bookings'));
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
        ]);

        return view('seeker.pages.booking-details', compact('booking'));
    }

    public function pay(Booking $booking)
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

        \App\Models\Payment::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]
        );

        return back()->with('success', 'Payment completed.');
    }

    public function create(int $providerUserId)
    {
        $provider = ProviderProfile::query()
            ->where('user_id', $providerUserId)
            ->whereHas('user', function ($u) {
                $u->where('role', \App\Models\User::ROLE_PROVIDER)
                    ->where('status', \App\Models\User::STATUS_ACTIVE);
            })
            ->with([
                'user:id,name',
                'services' => function ($q) {
                    $q->with([
                        'category:id,code,name',
                        'optionPricings.serviceOption:id,name,pricing_type,service_category_id'
                    ]);
                },
                'availabilitySlots' => function ($q) {
                    $q->where('is_booked', false)->orderBy('start_time');
                },
            ])
            ->firstOrFail();

        $services = $provider->services ?? collect();
        $slots = $provider->availabilitySlots ?? collect();

        // ✅ Important: filter optionPricings per service by category
        $services->each(function ($service) {
            $filtered = $service->optionPricings
                ->filter(function ($pricing) use ($service) {
                    $opt = $pricing->serviceOption;

                    return $opt
                        && (string) $opt->pricing_type === 'add-on'
                        && (int) $opt->service_category_id === (int) $service->service_category_id;
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
            'availability_slot_id' => ['required', 'integer'],
            'hours' => ['required', 'numeric', 'min:1', 'max:24'],
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
            return back()
                ->withErrors(['service_category_id' => 'Selected service is not available.'])
                ->withInput();
        }

        $slot = AvailabilitySlot::query()
            ->where('id', $data['availability_slot_id'])
            ->where('provider_user_id', $providerUserId)
            ->where('service_category_id', $data['service_category_id'])
            ->where('is_booked', false)
            ->first();

        if (!$slot) {
            return back()
                ->withErrors(['availability_slot_id' => 'Selected time slot is no longer available.'])
                ->withInput();
        }

        $hourlyRate = (float) $providerService->hourly_rate;
        $hours = (float) $data['hours'];
        $baseCost = $hourlyRate * $hours;

        // ✅ Only allow options that belong to the selected category
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

        $booking = DB::transaction(function () use (
            $data,
            $providerUserId,
            $hourlyRate,
            $baseCost,
            $optionsCost,
            $totalCost,
            $slot,
            $selectedOptions,
            $optionPriceMap
        ) {
            $booking = Booking::create([
                'customer_user_id' => auth()->id(),
                'provider_user_id' => $providerUserId,
                'service_category_id' => $data['service_category_id'],
                'availability_slot_id' => $data['availability_slot_id'],
                'hours' => $data['hours'],
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

            $slot->update(['is_booked' => true]);

            return $booking;
        });

        return redirect()
            ->route('seeker.bookings.show', $booking)
            ->with('success', 'Booking created. Status is pending.');
    }
}
