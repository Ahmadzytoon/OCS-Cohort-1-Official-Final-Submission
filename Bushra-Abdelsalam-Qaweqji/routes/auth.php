<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
// use App\Http\Controllers\Auth\RegisteredSeekerController;
// use App\Http\Controllers\Auth\RegisteredProviderController;
use App\Http\Controllers\Auth\RoleRegisterController;
use App\Http\Controllers\Auth\ProviderOnboardingController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {

    Route::prefix('register/provider')->name('register.provider.')->group(function () {
        Route::get('/', [RoleRegisterController::class, 'createProvider'])->name('create');
        Route::post('/', [RoleRegisterController::class, 'storeProvider'])->name('store');

        Route::get('onboarding', [ProviderOnboardingController::class, 'show'])->name('onboarding');

        Route::post('onboarding/step1', [ProviderOnboardingController::class, 'step1'])->name('onboarding.step1');
        Route::post('onboarding/step2', [ProviderOnboardingController::class, 'step2'])->name('onboarding.step2');
        Route::post('onboarding/complete', [ProviderOnboardingController::class, 'complete'])->name('onboarding.complete');

    });
    // Route::get('register', function () {
    //     return redirect()->route('register.seeker');
    // })->name('register');
    Route::prefix('register')->name('register.')->group(function () {
        Route::get('seeker', [RoleRegisterController::class, 'createSeeker'])->name('seeker');
        Route::post('seeker', [RoleRegisterController::class, 'storeSeeker'])->name('seeker.store');

    });
    // });

    // Route::prefix('register')->name('register.')->group(function () {
    //     Route::get('seeker', [RegisteredSeekerController::class, 'create'])->name('seeker');
    //     Route::post('seeker', [RegisteredSeekerController::class, 'store'])->name('seeker.store');

    //     Route::get('provider', [RegisteredProviderController::class, 'create'])->name('provider');
    //     Route::post('provider', [RegisteredProviderController::class, 'store'])->name('provider.store');
    // });

    // Route::get('register', [AuthenticatedSessionController::class, 'create'])
    //     ->name('register');

    // Route::post('register', [AuthenticatedSessionController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])
        ->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
