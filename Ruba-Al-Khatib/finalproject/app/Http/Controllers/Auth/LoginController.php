<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Invalid credentials',
            ])->withInput();
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // ⛔ حسابات تحتاج موافقة
        if (in_array($user->account_type, ['photographer', 'studio']) && $user->status !== 'approved') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Your account is under review. Please wait up to 2 business days.',
            ]);
        }

        // ✅ Redirect حسب النوع
        return match ($user->account_type) {
            'customer'     => redirect()->route('home'),
            'photographer' => redirect('/photographer'),
            'studio'       => redirect('/studio'),
            default        => redirect()->route('home'),
        };
    }

public function destroy(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/'); 
}
}
