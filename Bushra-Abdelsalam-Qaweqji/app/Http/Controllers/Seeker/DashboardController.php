<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $bookings = Booking::query()
            ->where('customer_user_id', auth()->id())
            ->with([
                'provider:id,name',
                'category:id,code,name',
                'slot:id,start_time,end_time',
            ])
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        return view('seeker.pages.dashboard', compact('bookings'));
    }
}
