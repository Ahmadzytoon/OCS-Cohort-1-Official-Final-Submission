<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FeatureMiddleware
{
    public function handle(Request $request, Closure $next, string $featureKey)
    {
        $user = $request->user();

        // لازم يكون مسجل دخول
        if (!$user) {
            return redirect()->route('login');
        }

        // لازم اشتراك فعّال
        if (!$user->hasActiveSubscription()) {
            return redirect()->route('pricing')
                ->with('error', 'You need an active subscription to use this feature.');
        }

        // لازم الميزة موجودة بالباقة
        if (!$user->canFeature($featureKey)) {
            return redirect()->route('pricing')
                ->with('error', 'This feature is not available in your current plan. Please upgrade.');
        }

        return $next($request);
    }
}
