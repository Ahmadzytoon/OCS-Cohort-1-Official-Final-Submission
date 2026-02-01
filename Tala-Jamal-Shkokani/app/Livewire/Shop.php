<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Shop extends Component
{
    use WithPagination;

    #[Url(as: 'aesthetic')]
    public $aesthetic = null;

    #[Url(as: 'price_tier')]
    public $price_tier = null;

    #[Url(as: 'color')]
    public $color = null;

    #[Url(as: 'sort')]
    public $sort = 'latest';

    #[Url(as: 'search')]
    public $search = '';

    #[Url(as: 'category')]
    public $categoryId = null;

    protected $paginationTheme = 'bootstrap';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedAesthetic()
    {
        $this->resetPage();
    }

    public function updatedPriceTier()
    {
        $this->resetPage();
    }

    public function updatedColor()
    {
        $this->resetPage();
    }

    public function setAesthetic($value)
    {
        $this->aesthetic = $value;
        $this->resetPage();
    }

    public function setPriceTier($value)
    {
        $this->price_tier = $value;
        $this->resetPage();
    }

    public function setColor($value)
    {
        $this->color = $value;
        $this->resetPage();
    }

    public function addToCart($productId)
    {
        try {
            $cartService = new \App\Services\CartService();
            $cartService->add($productId);

            $this->dispatch('cart-updated');
            $this->dispatch('open-cart');

            \Log::info('Shop Quick Add: Success', ['productId' => $productId]);
        } catch (\Exception $e) {
            \Log::error('Shop Quick Add Error: ' . $e->getMessage());
            $this->dispatch('swal:error', ['title' => 'Error', 'text' => 'Could not update your bag.']);
        }
    }

    public function render()
    {
        $query = Product::with(['category', 'images']);

        if ($this->aesthetic) {
            $query->where('aesthetic', $this->aesthetic);
        }

        if ($this->price_tier) {
            $query->where('price_tier', $this->price_tier);
        }

        if ($this->color) {
            $query->whereJsonContains('colors', $this->color);
        }

        if ($this->categoryId) {
            $query->where('category_id', $this->categoryId);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        switch ($this->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12);

        $title = $this->aesthetic ? ucfirst($this->aesthetic) . ' Collection' : 'Explore Wonderland';

        return view('livewire.shop', [
            'products' => $products,
            'title' => $title,
            'categories' => \Illuminate\Support\Facades\Cache::remember('shop_cats', 3600, fn() => Category::all())
        ]);
    }
}
