<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Book;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class AddToCart extends Component
{
    public Book $book;
    public $view = 'button'; // 'button' or 'details'
    public $quantity = 1;

    public function mount(Book $book, $view = 'button')
    {
        $this->book = $book;
        $this->view = $view;
    }

    public function addToCart()
    {
        if (!Auth::check()) {
            return $this->redirect(route('login') . '?redirect=' . urlencode(url()->previous()), navigate: false);
        }

        if ($this->book->status !== 'Active' || $this->book->stock_quantity <= 0) {
            return;
        }

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('book_id', $this->book->id)
            ->first();

        if ($item) {
            $item->increment('quantity', $this->quantity);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'book_id' => $this->book->id,
                'quantity' => $this->quantity
            ]);
        }

        $this->dispatch('cartUpdated');
        
        // Show success message via simple event or browser dispatch
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Added to cart!']);
    }

    public function render()
    {
        return view('livewire.user.add-to-cart');
    }
}
