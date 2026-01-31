<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
         $middleware->redirectUsersTo(function (Request $request) {
        $role = Auth::user()?->role;

        if ($role === 'admin') {
            return route('admin.dashboard');
        }

        if ($role === 'teacher') {
            return route('teacher.dashboard');
        }

        // student
        return route('pages.home');
    });

         $middleware->alias([
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ]);
    
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
         \Sentry\Laravel\Integration::handles($exceptions);
    })->create();
