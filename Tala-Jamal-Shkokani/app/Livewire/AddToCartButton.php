<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Services\CartService;

class AddToCartButton extends Component
{
    public $productId;
    public $productName;
    public $productPrice;
    public $productImage;
    public $productAesthetic;
    public $isSoldOut = false;
    public $stock = 0;

    public function mount($productId)
    {
        $this->productId = $productId;
        $product = Product::with('images')->find($productId);

        if ($product) {
            $this->productName = $product->name;
            $this->productPrice = $product->price ?? 0;
            $this->productImage = $product->image ?? ($product->images->first()?->url ?? asset('images/placeholder.jpg'));
            $this->productAesthetic = $product->aesthetic;
            $this->stock = $product->stock;
            $this->isSoldOut = $this->stock <= 0;
        } else {
            $this->productName = 'Curated Piece';
            $this->productPrice = 0;
            $this->productImage = asset('images/placeholder.jpg');
            $this->isSoldOut = true;
        }
    }

    public function addToCart($size = null, $color = null)
    {
        try {
            $product = Product::find($this->productId);

            if (!$product || $product->stock <= 0) {
                $this->dispatch('swal:error', ['title' => 'Sold Out', 'text' => 'This piece is currently unavailable.']);
                return;
            }

            $cartService = new CartService();
            $cartService->add($this->productId, 1, $size, $color);

            $this->dispatch('cart-updated');
            $this->dispatch('open-cart');

            \Log::info('Product added successfully via CartService: ' . $this->productId);

        } catch (\Throwable $e) {
            \Log::error('AddToCart Error: ' . $e->getMessage());
            $this->dispatch('swal:error', ['title' => 'Error', 'text' => 'Could not update your bag.']);
        }
    }

    public function render()
    {
        return view('livewire.add-to-cart-button');
    }
}
