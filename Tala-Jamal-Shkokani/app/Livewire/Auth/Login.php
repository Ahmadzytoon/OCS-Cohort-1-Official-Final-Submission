<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;
    public $context = '';

    public function mount()
    {
        $this->context = request('context', '');
    }

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        \Log::info('Attempting login for: ' . $this->email);

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            \Log::warning('Login failed (Credentials mismatch): ' . $this->email);
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $user = Auth::user();
        \Log::info('Login successful: ' . $user->email . ' (Role: ' . $user->role . ')');

        // Migrate guest cart to user
        try {
            $cartService = new \App\Services\CartService();
            $cartService->migrateGuestCartToUser($user->id);
            \Log::info('Cart migrated for user: ' . $user->id);
        } catch (\Exception $e) {
            \Log::error('Cart migration failed: ' . $e->getMessage());
        }

        session()->regenerate();
        \Log::info('Session regenerated. New Session ID: ' . session()->getId());

        // Redirect based on role
        if ($user->role === 'admin') {
            \Log::info('Redirecting to Admin Dashboard');
            return redirect()->intended(route('admin.dashboard'));
        }

        \Log::info('Redirecting to Home');
        return redirect()->intended(route('home'));
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
