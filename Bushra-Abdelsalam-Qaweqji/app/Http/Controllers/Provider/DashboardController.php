<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ProviderProfile;

class DashboardController extends Controller
{
    public function index()
    {
        $providerId = auth()->id();

        $profile = ProviderProfile::query()
            ->where('user_id', $providerId)
            ->first();

        $totalEarnings = Booking::query()
            ->where('provider_user_id', $providerId)
            ->where('status', 'completed')
            ->sum('total_cost');

        $completedCount = Booking::query()
            ->where('provider_user_id', $providerId)
            ->where('status', 'completed')
            ->count();

        $avgRating = $profile?->avg_rating ?? 0;

        $upcomingBookings = Booking::query()
            ->where('provider_user_id', $providerId)
            ->whereIn('status', ['pending', 'accepted'])
            ->with(['customer:id,name', 'category:id,code,name', 'slot:id,start_time,end_time'])
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        return view('provider.pages.dashboard', compact(
            'totalEarnings',
            'completedCount',
            'avgRating',
            'upcomingBookings'
        ));
    }
}
