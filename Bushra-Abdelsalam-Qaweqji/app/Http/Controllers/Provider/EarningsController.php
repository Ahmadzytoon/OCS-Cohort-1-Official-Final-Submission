<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class EarningsController extends Controller
{
    public function index()
    {
        $providerId = auth()->id();

        $completedBookings = Booking::query()
            ->where('provider_user_id', $providerId)
            ->where('status', 'completed')
            ->with(['customer:id,name', 'category:id,code,name'])
            ->orderByDesc('id')
            ->get();

        $totalEarnings = $completedBookings->sum('total_cost');
        $completedCount = $completedBookings->count();

        return view('provider.pages.earnings', compact('completedBookings', 'totalEarnings', 'completedCount'));
    }
}
