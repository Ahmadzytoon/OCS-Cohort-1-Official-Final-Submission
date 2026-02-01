<?php

namespace App\Http\Controllers\Photographer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhotographerBookingController extends Controller
{
    public function index(Request $request)
    {
        $photographer = Auth::user()->photographerProfile;

        $query = Booking::with('customer')
            ->where('provider_type', 'photographer')
            ->where('provider_id', $photographer->id);

        $status = $request->get('status', 'pending');
        $query->where('status', $status);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('customer', function ($qq) use ($q) {
                $qq->where('full_name', 'like', "%{$q}%")
                   ->orWhere('email', 'like', "%{$q}%");
            });
        }

        if ($request->filled('from')) {
            $query->whereDate('booking_date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('booking_date', '<=', $request->to);
        }

        $bookings = $query->orderBy('booking_date', 'asc')->get();

        // counts (لكل الحالات)
        $allForCounts = Booking::where('provider_type', 'photographer')
            ->where('provider_id', $photographer->id)
            ->get();

        $counts = [
            'pending'   => $allForCounts->where('status', 'pending')->count(),
            'approved'  => $allForCounts->where('status', 'approved')->count(),
            'rejected'  => $allForCounts->where('status', 'rejected')->count(),
            'completed' => $allForCounts->where('status', 'completed')->count(),
        ];

        return view('photographer.bookings.index', compact('bookings', 'counts'));
    }

    public function approve(Booking $booking)
    {
        $photographer = Auth::user()->photographerProfile;

        abort_unless(
            $booking->provider_type === 'photographer' && $booking->provider_id == $photographer->id,
            403
        );

        $booking->update(['status' => 'approved']);

        return back()->with('success', 'Booking approved.');
    }

    public function reject(Booking $booking)
    {
        $photographer = Auth::user()->photographerProfile;

        abort_unless(
            $booking->provider_type === 'photographer' && $booking->provider_id == $photographer->id,
            403
        );

        $booking->update(['status' => 'rejected']);

        return back()->with('success', 'Booking rejected.');
    }

    

public function show(Booking $booking)
{
    // تأكد إن الحجز لهذا المصور (provider_id = photographerProfile id)
    $providerId = auth()->user()->photographerProfile?->id;

    abort_unless($providerId && $booking->provider_type === 'photographer' && (int)$booking->provider_id === (int)$providerId, 403);

    $booking->load([
        'customer', // علاقة الزبون
        // 'sessionType' لو عندك
    ]);

    return view('photographer.bookings.show', [
        'booking' => $booking,
        'profile' => auth()->user()->photographerProfile,
    ]);
}

}
