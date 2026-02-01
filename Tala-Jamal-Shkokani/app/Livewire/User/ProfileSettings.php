<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ProfileSettings extends Component
{
    public $name;
    public $email;
    public $current_password;
    public $password;
    public $password_confirmation;
    public $style_persona;

    protected function rules()
    {
        return [
            'name' => ['required', 'min:3', 'regex:/^[a-zA-Z\s]{2,}$/'],
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'current_password' => $this->password ? 'required|current_password' : 'nullable',
            'password' => $this->password ? ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'] : 'nullable',
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

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->style_persona = $user->style_persona;
    }

    public function updateProfile()
    {
        $this->validate();

        $user = Auth::user();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->style_persona = $this->style_persona;

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        // Sync with session for immediate UI update in feed
        Session::put('user_aesthetic', $this->style_persona);

        $this->dispatch('swal:success', [
            'title' => 'Profile Updated',
            'text' => 'Your aesthetic profile has been synchronized.',
            'icon' => 'success'
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);
    }

    public function render()
    {
        return view('livewire.user.profile-settings');
    }
}
