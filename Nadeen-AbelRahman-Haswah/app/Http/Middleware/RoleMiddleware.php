<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login.create');
        }

        if (!in_array($user->role, $roles)) {
            // ممنوع يفتح صفحة مش إله
            abort(403);
        }

        return $next($request);
    }
}
