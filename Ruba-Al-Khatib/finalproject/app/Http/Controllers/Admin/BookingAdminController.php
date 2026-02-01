<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingAdminController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'all'); // all|pending|approved|rejected|cancelled|completed
        $q = $request->get('q');

        $query = Booking::query()->latest();

        if ($tab !== 'all') {
            $query->where('status', $tab);
        }

        if ($q) {
            $query->where(function ($w) use ($q) {
                $w->where('service_type', 'like', "%{$q}%")
                  ->orWhere('provider_type', 'like', "%{$q}%")
                  ->orWhere('id', $q);
            });
        }

        $bookings = $query->paginate(10)->withQueryString();

        return view('admin.bookings', compact('bookings','tab','q'));
    }

    public function show(Booking $booking)
    {
        return view('admin.bookings_show', compact('booking'));
    }
}
