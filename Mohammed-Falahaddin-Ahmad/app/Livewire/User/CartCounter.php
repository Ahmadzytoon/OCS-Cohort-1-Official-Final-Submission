<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class CartCounter extends Component
{
    public $count = 0;

    public function mount()
    {
        $this->updateCount();
    }

    #[On('cartUpdated')]
    public function updateCount()
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            $this->count = $cart ? $cart->items()->sum('quantity') : 0;
        } else {
            $this->count = 0;
        }
    }

    public function render()
    {
        return view('livewire.user.cart-counter');
    }
}
