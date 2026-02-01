<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\CartItem;
use App\Services\CartService;

class CartCount extends Component
{
    public $count = 0;

    #[On('cart-updated')]
    public function updateCount()
    {
        $cartService = new CartService();
        $this->count = $cartService->getCount();
        \Log::info('CartCount updated. Count: ' . $this->count);
    }

    public function mount()
    {
        $this->updateCount();
    }

    public function render()
    {
        return view('livewire.cart-count');
    }
}
