<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seeker\CleanerController;
use App\Http\Controllers\Seeker\BookingController;
use App\Http\Controllers\Seeker\DashboardController;
use App\Http\Controllers\Seeker\ProfileController as SeekerProfileController;
use App\Http\Controllers\Seeker\PayPalController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CustomersController as AdminCustomersController;
use App\Http\Controllers\Admin\ProvidersController as AdminProvidersController;
use App\Http\Controllers\Admin\BookingsController as AdminBookingsController;
use App\Http\Controllers\Admin\PaymentsController as AdminPaymentsController;
use App\Http\Controllers\Admin\UserStatusController as AdminUserStatusController;
use App\Http\Controllers\Provider\DashboardController as ProviderDashboardController;
use App\Http\Controllers\Provider\BookingsController as ProviderBookingsController;
use App\Http\Controllers\Provider\ServicesController as ProviderServicesController;
use App\Http\Controllers\Provider\AvailabilityController as ProviderAvailabilityController;
use App\Http\Controllers\Provider\EarningsController as ProviderEarningsController;
use App\Http\Controllers\Provider\ProfileController as ProviderProfileController;


Route::get('/', function () {
    return view('landing');
})->name('home');

require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| Authenticated shared routes (any logged-in user)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        $role = auth()->user()->role;

        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'provider' => redirect()->route('provider.dashboard'),
            default => redirect()->route('seeker.dashboard'),
        };
    })->name('dashboard');

    // Breeze profile routes (shared)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Admin Routes (auth + role:admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('customers', [AdminCustomersController::class, 'index'])->name('customers');
        Route::get('bookings', [AdminBookingsController::class, 'index'])->name('bookings');
        Route::get('providers', [AdminProvidersController::class, 'index'])->name('providers');
        Route::get('payments', [AdminPaymentsController::class, 'index'])->name('payments');
        Route::patch('users/{user}/status', [AdminUserStatusController::class, 'update'])->name('users.status');
    });


/*
|--------------------------------------------------------------------------
| Seeker Routes (auth + role:customer)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])
    ->prefix('seeker')
    ->name('seeker.')
    ->group(function () {

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


        Route::get('cleaners', [CleanerController::class, 'index'])
        ->name('providers-list');

        Route::get('providers/{providerUserId}', [CleanerController::class, 'show'])->name('provider-details');

        Route::get('providers/{providerUserId}/book', [BookingController::class, 'create'])
            ->name('bookings.create');
        Route::post('providers/{providerUserId}/book', [BookingController::class, 'store'])
            ->name('bookings.store');

        Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
        Route::post('bookings/{booking}/review', [BookingController::class, 'review'])->name('bookings.review');
        Route::get('bookings/{booking}/pay', [BookingController::class, 'payForm'])->name('bookings.pay.form');
        Route::post('bookings/{booking}/pay', [BookingController::class, 'pay'])->name('bookings.pay');

        Route::get('profile', [SeekerProfileController::class, 'index'])->name('profile');
        Route::post('profile', [SeekerProfileController::class, 'update'])->name('profile.update');

        Route::post('/payment/paypal/create', [PayPalController::class, 'create'])->name('paypal.create');
        Route::get('/payment/paypal/success', [PayPalController::class, 'success'])->name('paypal.success');
        Route::get('/payment/paypal/cancel', [PayPalController::class, 'cancel'])->name('paypal.cancel');

    });


/*
|--------------------------------------------------------------------------
| Provider Routes (auth + role:provider)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:provider'])
    ->prefix('provider')
    ->name('provider.')
    ->group(function () {

        Route::get('dashboard', [ProviderDashboardController::class, 'index'])->name('dashboard');

        Route::get('availability', [ProviderAvailabilityController::class, 'index'])->name('availability');
        Route::post('availability', [ProviderAvailabilityController::class, 'store'])->name('availability.store');
        Route::delete('availability/{slot}', [ProviderAvailabilityController::class, 'destroy'])->name('availability.destroy');

        Route::get('bookings', [ProviderBookingsController::class, 'index'])->name('bookings');
        Route::get('bookings/{booking}', [ProviderBookingsController::class, 'show'])->name('bookings.show');
        Route::post('bookings/{booking}/accept', [ProviderBookingsController::class, 'accept'])->name('bookings.accept');
        Route::post('bookings/{booking}/reject', [ProviderBookingsController::class, 'reject'])->name('bookings.reject');
        Route::post('bookings/{booking}/complete', [ProviderBookingsController::class, 'complete'])->name('bookings.complete');

        Route::get('earnings', [ProviderEarningsController::class, 'index'])->name('earnings');

        Route::get('services', [ProviderServicesController::class, 'index'])->name('services');
        Route::post('services', [ProviderServicesController::class, 'store'])->name('services.store');
        Route::patch('services/{providerService}', [ProviderServicesController::class, 'update'])->name('services.update');
        Route::delete('services/{providerService}', [ProviderServicesController::class, 'destroy'])->name('services.destroy');
        Route::post('services/{providerService}/options', [ProviderServicesController::class, 'updateOptions'])->name('services.options');

        Route::get('profile', [ProviderProfileController::class, 'index'])->name('profile');
        Route::patch('profile', [ProviderProfileController::class, 'update'])->name('profile.update');
    });
