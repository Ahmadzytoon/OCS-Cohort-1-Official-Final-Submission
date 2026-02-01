<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthorListController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\User\AboutController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ShopController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\User\AuthorController as UserAuthorController;

use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\User\CheckoutController;

// ==========================
// AUTH ROUTES
// ==========================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/register', [RegisterController::class, 'register']);


Route::get('/', [HomeController::class, 'index'])->name('user.home');
Route::get('/shop', [ShopController::class, 'index'])->name('user.shop');
Route::get('/shop/list', [ShopController::class, 'index'])->name('user.shop-list');
Route::get('/shop/{book}', [ShopController::class, 'show'])->name('user.shop-details');
Route::post('/books/{book}/reviews', [ShopController::class, 'storeReview'])->name('user.reviews.store');
Route::get('/search', [ShopController::class, 'index'])->name('user.search');

// About & Static Pages
Route::get('/about', [AboutController::class, 'index'])->name('user.about');
Route::get('/faq', fn() => view('user.faq'))->name('user.faq');
Route::get('/contact', fn() => view('user.contact'))->name('user.contact');

// Author Routes
Route::get('/author', [AuthorListController::class, 'index'])->name('user.team');
Route::get('/author/{author}', [UserAuthorController::class, 'show'])->name('user.team-details');

// Other Pages
Route::get('/404', fn() => view('errors.404'))->name('user.404');
Route::get('/news', fn() => view('user.news'))->name('user.news');
Route::get('/news-grid', fn() => view('user.news-grid'))->name('user.news-grid');
Route::get('/news-details', fn() => view('user.news-details'))->name('user.news-details');
Route::get('/news-contact', fn() => view('user.contact'))->name('user.news-contact');

// ==========================
// AUTHENTICATED USER ROUTES
// ==========================
Route::middleware(['auth'])->group(function () {
    
    //  CART ROUTES
    Route::get('/cart', [ShopController::class, 'cart'])->name('user.shop-cart');
    Route::post('/cart/add/{book}', [ShopController::class, 'addToCart'])->name('user.cart.add');
    Route::post('/cart/update', [ShopController::class, 'updateCart'])->name('user.cart.update');
    Route::delete('/cart/remove/{id}', [ShopController::class, 'removeFromCart'])->name('user.cart.remove');
    
    //  COUPON ROUTES
    Route::post('/cart/apply-coupon', [ShopController::class, 'applyCoupon'])->name('user.cart.apply-coupon');
    Route::delete('/cart/remove-coupon', [ShopController::class, 'removeCoupon'])->name('user.cart.remove-coupon');
  
    //  WISHLIST ROUTES — ONLY ONE REMOVE ROUTE
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('user.wishlist');
    Route::post('/wishlist/add/{book}', [WishlistController::class, 'add'])->name('user.wishlist.add');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('user.wishlist.remove');
    
    // CHECKOUT
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('user.checkout');
    Route::post('/checkout/payment-intent', [CheckoutController::class, 'createPaymentIntent'])->name('user.checkout.payment-intent');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('user.checkout.process');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('user.checkout.success');
    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('user.checkout.cancel');
    
    // USER PROFILE ROUTES
    Route::get('/user/profile', [ProfileController::class, 'edit'])->name('user.profile');
    Route::put('/user/profile', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::put('/user/profile/password', [ProfileController::class, 'updatePassword'])->name('user.profile.password');
    
    //  ORDER MANAGEMENT
    Route::get('/user/orders', [UserOrderController::class, 'index'])->name('user.orders');
    Route::get('/user/orders/{order}', [UserOrderController::class, 'show'])->name('user.order.show');
});

// ==========================
// ADMIN ROUTES
// ==========================
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    
    // User Management
    Route::resource('users', UserController::class)->except(['show']);
    Route::patch('/users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
    
    // Book Management
    Route::resource('books', BookController::class);
    Route::post('/books/{book}/discount', [BookController::class, 'storeDiscount'])->name('books.discount.store');
    Route::delete('/books/{book}/discount', [BookController::class, 'removeDiscount'])->name('books.discount.remove');
    
    // Author Management
    Route::resource('authors', AuthorController::class);
    
    // Category Management
    Route::resource('categories', CategoryController::class);
    
    // Order Management (Admin)
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Stock Management
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
    Route::post('/stock/{book}/adjust', [StockController::class, 'adjustStock'])->name('stock.adjust');
    Route::get('/stock/{book}/history', [StockController::class, 'showHistory'])->name('stock.history');
    
    // Coupon Management
    Route::resource('coupons', CouponController::class)->except(['show']);
    Route::patch('/coupons/{coupon}/toggle-status', [CouponController::class, 'toggleStatus'])->name('coupons.toggle-status');
    
    // Review Management
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/{review}', [ReviewController::class, 'show'])->name('reviews.show');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});