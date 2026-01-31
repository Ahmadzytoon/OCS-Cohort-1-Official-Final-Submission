<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create()
    {
        return view('site.loging.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable'],
        ]);

        $remember = (bool) ($request->boolean('remember'));

        if (!Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            throw ValidationException::withMessages([
                'email' => 'Invalid email or password.',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        return redirect()->to($this->redirectPathByRole($user->role));
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.create');
    }

    private function redirectPathByRole(?string $role): string
    {
        return match ($role) {
            'company_owner' => route('companyOwner.dashboard'),
            'department_manager' => route('departmentManager.dashboard'),
            'employee' => route('employee.dashboard'),
            default => '/',
        };
    }
}
