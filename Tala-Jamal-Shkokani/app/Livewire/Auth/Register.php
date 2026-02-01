<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Services\RoleResolver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Component;

class Register extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]{2,}$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
        ];
    }

    protected $messages = [
        'name.regex' => 'The name should only contain letters and spaces.',
        'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'user',
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Migrate guest cart items
        try {
            $cartService = new \App\Services\CartService();
            $cartService->migrateGuestCartToUser($user->id);
            \Log::info('Registration cart migration successful for: ' . $user->email);
        } catch (\Exception $e) {
            \Log::error('Registration cart migration failed: ' . $e->getMessage());
        }

        return redirect()->route('sparkle.quiz');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
