<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
#[Title('Account Settings')]
class AccountSettings extends Component
{
    public $name;
    public $email;
    public $role;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
    }

    public function render()
    {
        return view('livewire.admin.account-settings');
    }
}
