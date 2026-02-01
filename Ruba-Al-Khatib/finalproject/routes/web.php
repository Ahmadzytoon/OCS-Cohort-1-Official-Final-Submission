<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisteredUserWizardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\StudioUploadController;
use App\Http\Controllers\Auth\PhotographerUploadController;
use App\Http\Controllers\Auth\SocialAuthController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PhotographerApprovalController;
use App\Http\Controllers\Admin\StudioApprovalController;
use App\Http\Controllers\Admin\BookingAdminController;
use App\Http\Controllers\Admin\SubscriptionAdminController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BrowseController;

use App\Http\Controllers\Photographer\PhotographerDashboardController;
use App\Http\Controllers\Photographer\PhotographerProfileController;
use App\Http\Controllers\Photographer\PhotographerBookingController;
use App\Http\Controllers\Photographer\PhotographerPortfolioController;

use App\Http\Controllers\Main\LandingController;
use App\Http\Controllers\Main\PhotographerPublicController;

use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PricingController;

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/


Route::get('/', [HomeController::class, 'guest'])->name('home');

Route::get('/photographers', [BrowseController::class, 'photographers'])->name('photographers');
Route::get('/studio', [BrowseController::class, 'studios'])->name('studio');

Route::view('/about', 'main.about')->name('about');
Route::view('/contact', 'main.contact')->name('contact');
Route::view('/features', 'main.features')->name('features');
Route::view('/books', 'main.books')->name('books');

/*
|--------------------------------------------------------------------------
| Signup Wizard
|--------------------------------------------------------------------------
*/
Route::get('/signup', [RegisteredUserWizardController::class, 'createStep1'])->name('signup.step1');
Route::post('/signup', [RegisteredUserWizardController::class, 'storeStep1'])->name('signup.step1.store');

Route::get('/signup/user', [RegisteredUserWizardController::class, 'createUserStep2'])->name('signup.user');
Route::post('/signup/user', [RegisteredUserWizardController::class, 'storeUserStep2'])->name('signup.user.store');

Route::get('/signup/photographer', [RegisteredUserWizardController::class, 'createPhotographerStep2'])->name('signup.photographer');
Route::post('/signup/photographer', [RegisteredUserWizardController::class, 'storePhotographerStep2'])->name('signup.photographer.store');

Route::get('/signup/studio', [RegisteredUserWizardController::class, 'createStudioStep2'])->name('signup.studio');
Route::post('/signup/studio', [RegisteredUserWizardController::class, 'storeStudioStep2'])->name('signup.studio.store');

// Studio upload
Route::post('/signup/studio/upload', [StudioUploadController::class, 'upload'])->name('signup.studio.upload');
Route::delete('/signup/studio/upload', [StudioUploadController::class, 'destroy'])->name('signup.studio.upload.destroy');

// Pending page
Route::view('/account/pending', 'auth.pending')->name('account.pending');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'show'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Customer Home
|--------------------------------------------------------------------------
*/
Route::get('/customer/home', fn () => view('customer.home'))
    ->middleware('auth')
    ->name('customer.home');

/*
|--------------------------------------------------------------------------
| Upload Routes (Portfolio/Profile)
|--------------------------------------------------------------------------
*/
Route::post('/upload/photographer-portfolio', [PhotographerUploadController::class, 'upload'])
    ->name('upload.photographer.portfolio');

Route::delete('/upload/photographer-portfolio', [PhotographerUploadController::class, 'destroy'])
    ->name('upload.photographer.portfolio.destroy');

Route::post('/upload/photographer-profile', [PhotographerUploadController::class, 'uploadProfile'])
    ->name('upload.photographer.profile');

Route::delete('/upload/photographer-profile', [PhotographerUploadController::class, 'destroyProfile'])
    ->name('upload.photographer.profile.destroy');

/*
|--------------------------------------------------------------------------
| Admin Panel
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Users
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Photographer Approvals
        Route::get('/photographers', [PhotographerApprovalController::class, 'index'])->name('photographers');
        Route::get('/photographers/{user}', [PhotographerApprovalController::class, 'show'])->name('photographers.show');
        Route::post('/photographers/{user}/approve', [PhotographerApprovalController::class, 'approve'])->name('photographers.approve');
        Route::post('/photographers/{user}/reject', [PhotographerApprovalController::class, 'reject'])->name('photographers.reject');

        // Studio Approvals
        Route::get('/studios', [StudioApprovalController::class, 'index'])->name('studios');
        Route::get('/studios/{user}', [StudioApprovalController::class, 'show'])->name('studios.show');
        Route::post('/studios/{user}/approve', [StudioApprovalController::class, 'approve'])->name('studios.approve');
        Route::post('/studios/{user}/reject', [StudioApprovalController::class, 'reject'])->name('studios.reject');

        // Bookings
        Route::get('/bookings', [BookingAdminController::class, 'index'])->name('bookings');
        Route::get('/bookings/{booking}', [BookingAdminController::class, 'show'])->name('bookings.show');

        // Subscriptions
        Route::get('/subscriptions', [SubscriptionAdminController::class, 'index'])->name('subscriptions.index');
        Route::post('/subscriptions/{subscription}/approve', [SubscriptionAdminController::class, 'approve'])->name('subscriptions.approve');
        Route::post('/subscriptions/{subscription}/cancel', [SubscriptionAdminController::class, 'cancel'])->name('subscriptions.cancel');
    });

/*
|--------------------------------------------------------------------------
| Photographer Routes (ONE GROUP ONLY)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'photographer', 'ensurePhotographer'])
    ->prefix('photographer')
    ->name('photographer.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [PhotographerDashboardController::class, 'index'])->name('dashboard');

        // Profile
        Route::get('/profile', [PhotographerProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [PhotographerProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [PhotographerProfileController::class, 'update'])->name('profile.update');

        // Portfolio
        Route::get('/portfolio', [PhotographerPortfolioController::class, 'index'])->name('portfolio.index');

        Route::post('/portfolio', [PhotographerPortfolioController::class, 'store'])
            ->middleware('feature:portfolio_upload')
            ->name('portfolio.store');

        Route::delete('/portfolio/{id}', [PhotographerPortfolioController::class, 'destroy'])
            ->middleware('feature:portfolio_upload')
            ->name('portfolio.destroy');

        // Bookings
        Route::get('/bookings', [PhotographerBookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}', [PhotographerBookingController::class, 'show'])->name('bookings.show');

        Route::post('/bookings/{booking}/approve', [PhotographerBookingController::class, 'approve'])
            ->middleware('feature:accept_booking')
            ->name('bookings.approve');

        Route::post('/bookings/{booking}/reject', [PhotographerBookingController::class, 'reject'])
            ->middleware('feature:accept_booking')
            ->name('bookings.reject');
    });

/*
|--------------------------------------------------------------------------
| Public Photographer Profile (Customers/Guests)
|--------------------------------------------------------------------------
*/
Route::get('/photographers/{photographer}', [PhotographerPublicController::class, 'show'])
    ->name('photographer.public.show');

/*
|--------------------------------------------------------------------------
| Social Auth
|--------------------------------------------------------------------------
*/
Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])
    ->whereIn('provider', ['google', 'facebook'])
    ->name('social.redirect');

Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])
    ->whereIn('provider', ['google', 'facebook'])
    ->name('social.callback');

/*
|--------------------------------------------------------------------------
| Subscriptions (Customer/Photographer/Studio)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe');
    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');

    Route::get('/checkout', function () {
        return view('main.checkout');
    })->name('checkout');
});

/*
|--------------------------------------------------------------------------
| Pricing Page (Public)
|--------------------------------------------------------------------------
*/
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');


/*
|-------------------------------------------
|Booking Availability Check API
|-------------------------------------------
*/
use App\Http\Controllers\AvailabilityController;

Route::get('/availability', [AvailabilityController::class, 'check']) ->name('availability.check');


use App\Http\Controllers\BookingController;


    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings', [BookingController::class, 'my'])->name('bookings.my');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');



