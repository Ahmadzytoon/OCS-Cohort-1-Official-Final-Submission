<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Session;

#[Layout('layouts.app')]
class Cart extends Component
{
    public $cart = [];
    public $total = 0;

    public function mount()
    {
        $this->updateCart();
    }

    #[On('cart-updated')]
    public function updateCart()
    {
        $cartService = new \App\Services\CartService();
        $items = $cartService->getItems();

        $this->cart = $items->map(function ($item) {
            return [
                'item_id' => $item->id,
                'id' => $item->product_id,
                'name' => $item->product->name,
                'price' => $item->product->discounted_price,
                'original_price' => $item->product->price,
                'has_discount' => $item->product->hasDiscount(),
                'discount_percentage' => $item->product->effective_discount,
                'image' => $item->product->image ?? ($item->product->images->first()?->url ?? asset('images/placeholder.jpg')),
                'size' => $item->size,
                'color' => $item->color,
                'quantity' => $item->quantity,
                'out_of_stock' => $item->product->stock <= 0
            ];
        })->toArray();

        $this->total = $cartService->getSubtotal();
    }

    public function removeFromCart($itemId)
    {
        $cartService = new \App\Services\CartService();
        $cartService->remove($itemId);
        $this->updateCart();
        $this->dispatch('cart-updated');
    }

    public function increment($itemId)
    {
        $cartService = new \App\Services\CartService();
        $cartItem = \App\Models\CartItem::with('product')->find($itemId);

        if ($cartItem && $cartItem->quantity < $cartItem->product->stock) {
            $cartService->updateQuantity($itemId, $cartItem->quantity + 1);
            $this->updateCart();
            $this->dispatch('cart-updated');
        } else {
            $this->dispatch('swal:error', [
                'title' => 'Limit Reached',
                'text' => 'Maximum stock reached.',
                'icon' => 'warning'
            ]);
        }
    }

    public function decrement($itemId)
    {
        $cartService = new \App\Services\CartService();
        $cartItem = \App\Models\CartItem::find($itemId);

        if ($cartItem) {
            $cartService->updateQuantity($itemId, $cartItem->quantity - 1);
            $this->updateCart();
            $this->dispatch('cart-updated');
        }
    }

    public function checkout()
    {
        return redirect()->route('checkout');
    }

    public function calculateTotal()
    {
        // Handled in updateCart via Service
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
