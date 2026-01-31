<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{

    public const ROLE_ADMIN = 'admin';
    public const ROLE_PROVIDER = 'provider';

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
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        if ($user->status !== 'active') {

            Auth::logout();
            return back()->withErrors([
                'email' => 'Your account is not activated yet. Please contact support.',
            ]);
        }

        $redirectTo = match ($request->user()->role) {
            User::ROLE_ADMIN => route('admin.dashboard', absolute: false),
            User::ROLE_PROVIDER => route('provider.dashboard', absolute: false),
            default => route('seeker.providers-list', absolute: false),
        };

        return redirect()->intended($redirectTo);

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
