<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Services\CartService;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $cart = $request->session()->get('cart');

        $request->authenticate();

        $request->session()->regenerate();

        if ($cart) {
            $request->session()->put('cart', $cart);
        }

        // Redirect based on user role and persona
        $user = Auth::user();

        // Migrate guest cart items to the user's account
        $cartService = new CartService();
        $cartService->migrateGuestCartToUser($user->id);

        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('home'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $cart = $request->session()->get('cart');

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($cart) {
            $request->session()->put('cart', $cart);
        }

        return redirect('/');
    }
}
