<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'photographer' => \App\Http\Middleware\PhotographerMiddleware::class,
            'ensurePhotographer' => \App\Http\Middleware\EnsurePhotographer::class,
            'active.subscription' => \App\Http\Middleware\EnsureActiveSubscription::class,
            'feature' => \App\Http\Middleware\FeatureMiddleware::class,

        ]);
    })
    
    ->withExceptions(function (Exceptions $exceptions) {})
    ->create();
