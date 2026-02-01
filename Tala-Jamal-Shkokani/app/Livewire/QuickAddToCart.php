<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;

class QuickAddToCart extends Component
{
    public $product;
    public $isOpen = false;
    public $selectedSize = null;
    public $selectedColor = null;

    #[On('quick-add-to-cart')]
    public function openModal($productId)
    {
        if (is_array($productId) && isset($productId['productId'])) {
            $productId = $productId['productId'];
        }

        $this->product = Product::with('images')->find($productId);

        if (!$this->product || $this->product->stock <= 0) {
            $this->dispatch('swal:error', [
                'title' => 'Sold Out',
                'text' => 'This piece is no longer available.',
                'icon' => 'error'
            ]);
            return;
        }

        // Auto selection if only one option? Maybe later. For now require manual choice.
        $this->reset(['selectedSize', 'selectedColor']);
        $this->isOpen = true;
    }

    public function close()
    {
        $this->isOpen = false;
        $this->reset(['product', 'selectedSize', 'selectedColor']);
    }

    public function isColorAvailable($color)
    {
        return $this->product->variants
            ->where('color', $color)
            ->where('stock', '>', 0)
            ->count() > 0;
    }

    public function isSizeAvailable($size)
    {
        if (!$this->selectedColor) {
            return $this->product->variants
                ->where('size', $size)
                ->where('stock', '>', 0)
                ->count() > 0;
        }

        return $this->product->variants
            ->where('color', $this->selectedColor)
            ->where('size', $size)
            ->where('stock', '>', 0)
            ->count() > 0;
    }

    public function getStockForCurrentSelection()
    {
        if ($this->selectedColor && $this->selectedSize) {
            $variant = $this->product->variants
                ->where('color', $this->selectedColor)
                ->where('size', $this->selectedSize)
                ->first();
            return $variant ? (int) $variant->stock : 0;
        }
        return $this->product->stock;
    }

    public function addToBag()
    {
        if (!$this->product)
            return;

        // Validation
        $rules = [];
        if ($this->product->sizes && count($this->product->sizes) > 0) {
            $rules['selectedSize'] = 'required';
        }
        if ($this->product->colors && count($this->product->colors) > 0) {
            $rules['selectedColor'] = 'required';
        }

        if (!empty($rules)) {
            $this->validate($rules, [
                'selectedSize.required' => 'Please select a size.',
                'selectedColor.required' => 'Please select a color.'
            ]);
        }

        // Variant Stock Check
        if ($this->getStockForCurrentSelection() <= 0) {
            $this->dispatch('swal:error', [
                'title' => 'Unavailable',
                'text' => 'This specific combination is currently out of stock.',
                'icon' => 'warning'
            ]);
            return;
        }

        try {
            $cartService = new \App\Services\CartService();
            $cartService->add($this->product->id, 1, $this->selectedSize, $this->selectedColor);

            $this->isOpen = false;
            $this->dispatch('cart-updated');
            $this->dispatch('open-cart');

            $this->dispatch('swal:success', [
                'title' => 'Added to Bag',
                'text' => "{$this->product->name} is now in your bag.",
                'icon' => 'success'
            ]);

            $this->reset(['product', 'selectedSize', 'selectedColor']);
        } catch (\Exception $e) {
            \Log::error('QuickAddToCart Error: ' . $e->getMessage());
            $this->dispatch('swal:error', ['title' => 'Error', 'text' => 'Could not update your bag.']);
        }
    }

    public function render()
    {
        return view('livewire.quick-add-to-cart');
    }
}
