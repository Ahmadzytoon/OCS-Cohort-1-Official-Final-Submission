<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->isAdmin()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Admin login successful!',
                    'redirect' => '/admin/dashboard'
                ]);
            }

            if ($user->isAuthor()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Author login successful!',
                    'redirect' => '/author/dashboard'
                ]);
            }

            // Regular user
            return response()->json([
                'success' => true,
                'message' => 'Login successful!',
                'redirect' => $request->input('redirect') ?: '/'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid email or password.'
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showLoginForm()
{
    return view('login.login');
}
}