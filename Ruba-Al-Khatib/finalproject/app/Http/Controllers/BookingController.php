<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Photographer;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        if (!auth()->user()) {
            return redirect()->route('login');
        }

        $data = $request->validate([
            'provider' => ['required', Rule::in(['photographer','studio'])],
            'provider_id' => ['required','integer'],
            'session_type_id' => ['nullable','integer'],
            'booking_date' => ['required','date','after_or_equal:today'],
            'booking_time' => ['required','date_format:H:i'],
            'location_type' => ['required','string','max:50'],
            'location_address' => ['nullable','string','max:255'],
            'notes' => ['nullable','string','max:2000'],
        ]);

        // تأكيد وجود المزود
        if ($data['provider'] === 'photographer') {
            Photographer::findOrFail($data['provider_id']);
        } else {
            Studio::findOrFail($data['provider_id']);
        }

        $time = $data['booking_time'] . ':00';

        // منع حجز نفس الوقت (pending/approved)
        $taken = Booking::query()
            ->where('provider_type', $data['provider'])
            ->where('provider_id', $data['provider_id'])
            ->whereDate('booking_date', $data['booking_date'])
            ->where('booking_time', $time)
            ->whereIn('status', ['pending','approved'])
            ->exists();

        if ($taken) {
            return back()->withErrors([
                'booking_time' => 'This time is already booked.'
            ])->withInput();
        }

        Booking::create([
            'customer_id' => auth()->guard()->user()->id,
            'provider_type' => $data['provider'],
            'provider_id' => $data['provider_id'],
            'session_type_id' => $data['session_type_id'] ?? 1,
            'booking_date' => $data['booking_date'],
            'booking_time' => $time,
            'location_type' => $data['location_type'],
            'location_address' => $data['location_address'] ?? null,
            'price' => 0,
            'status' => 'pending',
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()
    ->route('bookings.my')
    ->with('success', 'Booking submitted (pending approval).');


    }
}
