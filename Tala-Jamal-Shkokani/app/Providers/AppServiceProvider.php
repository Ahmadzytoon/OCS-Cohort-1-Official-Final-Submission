<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ProductVariant;
use App\Observers\ProductVariantObserver;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        ProductVariant::observe(ProductVariantObserver::class);

        // Ensure session is initialized for guest users (data will be saved by middleware)
        if (!app()->runningInConsole() && !session()->has('active')) {
            session()->put('active', true);
        }
    }
}
