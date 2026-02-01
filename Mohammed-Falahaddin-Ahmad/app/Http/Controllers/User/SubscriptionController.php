<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plans = Plan::where('is_active', true)->get();
        $currentSubscription = Auth::user()->subscription;
        return view('user.plans', compact('plans', 'currentSubscription'));
    }

    public function subscribe(Plan $plan)
    {
        $user = Auth::user();

        // Expire current active subscription
        Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->update(['status' => 'expired']);

        $duration = $plan->duration_type === 'month' ? 1 : 12;

        Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'starts_at' => now(),
            'expires_at' => now()->addMonths($duration),
            'status' => 'active',
        ]);

        // Upgrade user role to author if they subscribed
        $user->update(['role' => 'author']);

        return redirect()->route('author.dashboard')->with('success', 'Subscription active! Welcome to the Author Dashboard.');
    }
}
