<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show login page
     */
    public function show()
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return back()
                ->withErrors(['email' => 'Invalid email or password'])
                ->withInput();
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->account_type === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->account_type === 'customer') {
            return redirect()->route('customer.home');
        }

        if (in_array($user->account_type, ['photographer', 'studio'])) {

            if (($user->status ?? 'pending') !== 'approved') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('account.pending')
                    ->with('success', 'Your account is pending admin approval.');
            }

            // ✅ Approved: وجّهيه حسب نوع الحساب
            if ($user->account_type === 'photographer') {
                return redirect()->route('photographer.dashboard');
            }

            // studio (لسا ما عملنا داشبورد)
            // لاحقاً: return redirect()->route('studio.dashboard');
            return redirect()->route('home');
        }


        return redirect()->route('home');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
