<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // لو مش مسجل دخول
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role;

        // لو الدور غير مسموح
        if (!in_array($userRole, $roles, true)) {
            abort(403); // Forbidden
        }

        return $next($request);
    }
}
