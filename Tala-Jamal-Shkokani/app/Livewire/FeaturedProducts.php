<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Services\CartService;

class FeaturedProducts extends Component
{
    public $type = 'featured'; // featured, recent, top
    public $activePersona = null;

    public function setPersona($persona)
    {
        $this->activePersona = $persona;
    }

    public function addToCart($productId)
    {
        try {
            $cartService = new CartService();
            $cartService->add($productId);

            $this->dispatch('cart-updated');
            $this->dispatch('open-cart');

            \Log::info('FeaturedProducts Quick Add: Success', ['productId' => $productId]);
        } catch (\Exception $e) {
            \Log::error('FeaturedProducts Quick Add Error: ' . $e->getMessage());
            $this->dispatch('swal:error', ['title' => 'Error', 'text' => 'Could not update your bag.']);
        }
    }

    public function render()
    {
        $query = Product::where('status', 'active')->where('stock', '>', 0);

        if ($this->activePersona) {
            $query->where('aesthetic', $this->activePersona);
        }

        if ($this->type === 'top') {
            $products = $query->inRandomOrder()->limit(4)->get();
        } elseif ($this->type === 'recent') {
            $products = $query->latest()->limit(4)->get();
        } else {
            // Default to featured
            $products = (clone $query)->where('is_featured', true)->limit(4)->get();

            if ($products->count() < 4) {
                $extra = $query->whereNotIn('id', $products->pluck('id'))
                    ->inRandomOrder()
                    ->limit(4 - $products->count())
                    ->get();
                $products = $products->concat($extra);
            }
        }

        return view('livewire.featured-products', [
            'products' => $products
        ]);
    }
}
