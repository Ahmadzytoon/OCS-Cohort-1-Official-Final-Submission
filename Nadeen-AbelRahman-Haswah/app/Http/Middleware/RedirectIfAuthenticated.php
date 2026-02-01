<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {


                if ($guard === 'admin') {
                    return redirect()->route('admin.dashboard');
                }

                // (اختياري للمستقبل) أي guard ثاني
                $user = Auth::guard($guard)->user();

                return match ($user->role) {
                    'company_owner' => redirect()->route('companyOwner.dashboard'),
                    'department_manager' => redirect()->route('departmentManager.dashboard'),
                    'employee' => redirect()->route('employee.dashboard'),
                    default => redirect('/'),
                };
                // return redirect('/');
            }
        }

        return $next($request);
    }
}
