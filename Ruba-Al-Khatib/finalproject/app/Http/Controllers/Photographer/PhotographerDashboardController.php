<?php

namespace App\Http\Controllers\Photographer;

use App\Http\Controllers\Controller;

class PhotographerDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $profile = $user->photographerProfile;

        // لاحقًا بنربطهم من جدول bookings
        $stats = [
            'upcoming' => 0,
            'pending' => 0,
            'earnings' => 0,
            'rating' => null,
        ];

        $recentBookings = collect(); // مؤقت لحد ما نعمل جدول bookings

        return view('photographer.dashboard', compact(
            'profile',
            'stats',
            'recentBookings'
        ));

        
    }
    
}
