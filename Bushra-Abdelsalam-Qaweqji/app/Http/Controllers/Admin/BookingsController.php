<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class BookingsController extends Controller
{
    public function index()
    {
        $bookings = Booking::query()
            ->with([
                'customer:id,name',
                'provider:id,name',
                'category:id,code,name',
                'slot:id,start_time,end_time',
                'payment:id,booking_id,payment_status',
            ])
            ->orderByDesc('id')
            ->get();

        return view('admin.bookings', compact('bookings'));
    }
}
