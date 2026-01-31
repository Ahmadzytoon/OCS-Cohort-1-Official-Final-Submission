<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            \Log::info('Admin access check', [
                'email' => auth()->user()->email,
                'role' => auth()->user()->role,
                'is_admin' => auth()->user()->role === 'admin'
            ]);

            if (auth()->user()->role === 'admin') {
                return $next($request);
            }
        } else {
            \Log::warning('Unauthorized admin access attempt (Not logged in)');
        }

        return redirect('/')->with('error', 'You do not have administrative access.');
    }
}
