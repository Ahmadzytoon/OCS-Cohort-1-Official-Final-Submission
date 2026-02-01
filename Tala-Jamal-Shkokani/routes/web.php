<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EnterSessionController;
use App\Livewire\Shop;
use App\Livewire\Cart;
use App\Livewire\Checkout;
use App\Livewire\SparkleQuiz;
use App\Livewire\PersonalizedFeed;
use App\Livewire\User\Orders as UserOrders;
use App\Livewire\User\Wishlist as UserWishlist;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/enter-session', EnterSessionController::class)->name('enter.session');

// Debug route
Route::get('/debug-auth', function () {
    return [
        'check' => auth()->check(),
        'user' => auth()->user(),
        'session_id' => session()->getId(),
        'role' => auth()->check() ? auth()->user()->role : null,
        'is_admin_check' => auth()->check() ? (auth()->user()->role === 'admin') : false,
        'env' => config('app.env'),
        'url' => config('app.url'),
        'session_driver' => config('session.driver'),
    ];
});

Route::get('/debug-recommendations', function () {
    return view('debug-recommendations');
});

// Shop Universe
Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/', Shop::class)->name('index');
    Route::get('/{id}', \App\Livewire\ProductDetail::class)->name('show');
});

// Discovery Engine
Route::get('/style-quiz', SparkleQuiz::class)->name('sparkle.quiz');
Route::get('/my-edit', PersonalizedFeed::class)->name('personalized.feed');

// Cart & Acquisition
Route::get('/cart', Cart::class)->name('cart');
Route::get('/checkout', Checkout::class)->name('checkout');
Route::get('/checkout/success/{order}', function (\App\Models\Order $order) {
    return view('checkout.success', compact('order'));
})->name('checkout.success');

// Stripe Payments
Route::prefix('stripe')->name('stripe.')->group(function () {
    Route::post('/payment-intent', [\App\Http\Controllers\StripeController::class, 'createPaymentIntent'])->name('payment-intent');
    Route::get('/success', [\App\Http\Controllers\StripeController::class, 'handleSuccess'])->name('success');
    Route::get('/cancel', [\App\Http\Controllers\StripeController::class, 'handleCancel'])->name('cancel');
    Route::post('/webhook', [\App\Http\Controllers\StripeController::class, 'handleWebhook'])->name('webhook');
    Route::post('/refund', [\App\Http\Controllers\StripeController::class, 'createRefund'])->middleware(['auth', 'admin'])->name('refund');
});

// Authenticated User Universe
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::get('/profile', function () {
        return redirect()->route('account.profile.edit');
    })->name('profile');

    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/orders', UserOrders::class)->name('orders');
        Route::get('/wishlist', UserWishlist::class)->name('wishlist');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

// Curator (Admin) Panel
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');

    // Inventory Management
    Route::get('/categories', \App\Livewire\Admin\CategoryManager::class)->name('categories.index');
    Route::resource('categories', CategoryController::class)->except(['index']);

    Route::get('products/trash', [ProductController::class, 'trash'])->name('products.trash');
    Route::put('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::get('/products', \App\Livewire\Admin\ProductManager::class)->name('products.index');

    // Business Intelligence & Operations
    Route::get('/orders', \App\Livewire\Admin\OrderManager::class)->name('orders.index');
    Route::get('/users', \App\Livewire\Admin\UserManager::class)->name('users.index');
    Route::get('/personas', \App\Livewire\Admin\PersonaManager::class)->name('personas.index');
    Route::get('/reviews', \App\Livewire\Admin\ReviewManager::class)->name('reviews.index');

    // Account Management
    Route::get('/account', \App\Livewire\Admin\AccountSettings::class)->name('account');
});

require __DIR__ . '/auth.php';


// Extension test route
Route::get('/php-info', function () {
    $extensions = [
        'Required' => [
            'curl' => 'HTTP requests',
            'fileinfo' => 'File type detection',
            'mbstring' => 'Multibyte strings',
            'openssl' => 'Encryption',
            'pdo_mysql' => 'MySQL database',
            'pdo_sqlite' => 'SQLite database',
            'sqlite3' => 'SQLite3',
            'xml' => 'XML parsing',
            'zip' => 'Zip archives',
            'gd' => 'Image processing',
        ],
        'Optional' => [
            'bcmath' => 'Precise mathematics',
            'exif' => 'Image metadata',
            'intl' => 'Internationalization',
            'soap' => 'SOAP client',
            'xsl' => 'XSL transformations',
        ]
    ];

    $results = [];
    foreach ($extensions as $category => $extList) {
        foreach ($extList as $ext => $purpose) {
            $loaded = extension_loaded($ext);
            $results[] = [
                'category' => $category,
                'extension' => $ext,
                'loaded' => $loaded,
                'purpose' => $purpose,
                'icon' => $loaded ? '?' : '?'
            ];
        }
    }

    return view('extensions-test', ['results' => $results]);
});

// Quick performance test
Route::get('/php-perf', function () {
    $start = microtime(true);

    // Test common operations
    $tests = [
        'String operations' => function () {
            return str_repeat('test', 10000);
        },
        'Array operations' => function () {
            $arr = range(1, 10000);
            return array_sum($arr);
        },
        'Math operations' => function () {
            $result = 0;
            for ($i = 0; $i < 10000; $i++) {
                $result += sqrt($i);
            }
            return $result;
        }
    ];

    $results = [];
    foreach ($tests as $name => $test) {
        $testStart = microtime(true);
        $test();
        $results[$name] = round((microtime(true) - $testStart) * 1000, 2) . 'ms';
    }

    $totalTime = round((microtime(true) - $start) * 1000, 2);

    return response()->json([
        'php_version' => phpversion(),
        'memory_limit' => ini_get('memory_limit'),
        'opcache_enabled' => extension_loaded('opcache'),
        'tests' => $results,
        'total_time' => $totalTime . 'ms',
        'extensions_loaded' => count(get_loaded_extensions())
    ]);
});
