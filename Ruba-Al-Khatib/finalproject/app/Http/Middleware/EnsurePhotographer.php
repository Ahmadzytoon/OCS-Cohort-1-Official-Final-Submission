<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsurePhotographer
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // فقط موافقة الادمن
        if (($user->status ?? 'pending') !== 'approved') {
            return redirect()->route('account.pending');
        }

        return $next($request);
    }
}
