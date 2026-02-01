<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureActiveSubscription
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // بس للمصور/ستديو
        if ($user && in_array($user->account_type, ['photographer','studio'])) {

            if (!$user->hasActiveSubscription()) {
                return redirect()->route('pricing')
                    ->with('error', 'You need an active subscription to use this feature.');
            }
        }

        return $next($request);
    }
}
