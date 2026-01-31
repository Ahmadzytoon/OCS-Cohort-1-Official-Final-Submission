<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function index(Request $request)
    {
        return view('provider.pages.bookings');
    }

    public function show(Booking $booking)
    {
        $this->ensureOwner($booking);

        $booking->load([
            'customer:id,name',
            'category:id,code,name',
            'slot:id,start_time,end_time',
            'payment',
        ]);

        return view('provider.pages.booking-details', compact('booking'));
    }

    public function accept(Booking $booking)
    {
        $this->ensureOwner($booking);
        $booking->update(['status' => 'accepted']);

        return back()->with('success', 'Booking accepted.');
    }

    public function reject(Booking $booking)
    {
        $this->ensureOwner($booking);
        $booking->update(['status' => 'rejected']);

        return back()->with('success', 'Booking rejected.');
    }

    public function complete(Booking $booking)
    {
        $this->ensureOwner($booking);
        $booking->load('payment');

        if (!$booking->payment || $booking->payment->payment_status !== 'paid') {
            return back()->withErrors(['status' => 'Booking must be paid before it can be completed.']);
        }

        $booking->update(['status' => 'completed']);

        return back()->with('success', 'Booking marked as completed.');
    }

    private function ensureOwner(Booking $booking): void
    {
        if ($booking->provider_user_id !== auth()->id()) {
            abort(403);
        }
    }
}
