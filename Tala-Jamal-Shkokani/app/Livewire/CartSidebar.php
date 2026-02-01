<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Product;
use App\Services\CartService;
use App\Services\StyleRecommendationService;

class CartSidebar extends Component
{
    public $cart = [];
    public $total = 0;
    public $recommendations = [];

    public function mount()
    {
        $this->updateCart();
    }

    #[On('cart-updated')]
    public function updateCart()
    {
        $cartService = new CartService();
        $items = $cartService->getItems();

        $this->cart = $items->map(function ($item) {
            if (!$item->product) {
                // Handle orphaned cart items gracefully
                return null;
            }
            return [
                'item_id' => $item->id, // DB record ID
                'id' => $item->product_id,
                'name' => $item->product->name,
                'price' => $item->product->discounted_price,
                'image' => $item->product->image ?? ($item->product->images->first()?->url ?? asset('images/placeholder.jpg')),
                'size' => $item->size,
                'color' => $item->color,
                'quantity' => $item->quantity,
                'aesthetic' => $item->product->aesthetic,
                'out_of_stock' => $item->product->stock <= 0
            ];
        })->filter()->values()->toArray();

        $this->total = $cartService->getSubtotal();

        $recommendationService = new StyleRecommendationService();
        $this->recommendations = $recommendationService->getRecommendations(collect($this->cart), 3);

        \Log::info('CartSidebar updated via CartService.', [
            'count' => count($this->cart),
            'session_id' => session()->getId(),
            'user' => auth()->user()?->email
        ]);
    }

    public function removeFromCart($itemId)
    {
        $cartService = new CartService();
        $cartService->remove($itemId);
        $this->updateCart();
        $this->dispatch('cart-updated');
    }

    public function increment($itemId)
    {
        $cartItem = \App\Models\CartItem::with('product')->find($itemId);
        if ($cartItem && $cartItem->quantity < $cartItem->product->stock) {
            $cartItem->increment('quantity');
            $this->updateCart();
            $this->dispatch('cart-updated');
        }
    }

    public function decrement($itemId)
    {
        $cartItem = \App\Models\CartItem::find($itemId);
        if ($cartItem) {
            if ($cartItem->quantity > 1) {
                $cartItem->decrement('quantity');
            } else {
                $cartItem->delete();
            }
            $this->updateCart();
            $this->dispatch('cart-updated');
        }
    }

    public function checkout()
    {
        return redirect()->route('checkout');
    }

    public function render()
    {
        return view('livewire.cart-sidebar');
    }
}
