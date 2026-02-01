<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class WishlistCounter extends Component
{
    public $count = 0;

    public function mount()
    {
        $this->updateCount();
    }

    #[On('wishlistUpdated')]
    public function updateCount()
    {
        if (Auth::check()) {
            $this->count = Auth::user()->wishlists()->count();
        } else {
            $this->count = 0;
        }
    }

    public function render()
    {
        return view('livewire.user.wishlist-counter');
    }
}
