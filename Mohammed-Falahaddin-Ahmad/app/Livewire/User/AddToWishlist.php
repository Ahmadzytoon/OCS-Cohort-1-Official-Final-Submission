<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Book;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class AddToWishlist extends Component
{
    public Book $book;
    public $isWishlisted = false;

    public function mount(Book $book)
    {
        $this->book = $book;
        $this->checkIfWishlisted();
    }

    public function checkIfWishlisted()
    {
        if (Auth::check()) {
            $this->isWishlisted = Wishlist::where('user_id', Auth::id())
                ->where('book_id', $this->book->id)
                ->exists();
        }
    }

    public function toggleWishlist()
    {
        if (!Auth::check()) {
            return $this->redirect(route('login') . '?redirect=' . urlencode(url()->previous()), navigate: false);
        }

        if ($this->isWishlisted) {
            Wishlist::where('user_id', Auth::id())
                ->where('book_id', $this->book->id)
                ->delete();
            $this->isWishlisted = false;
            $this->dispatch('notify', ['type' => 'info', 'message' => 'Removed from wishlist']);
        } else {
            Wishlist::firstOrCreate([
                'user_id' => Auth::id(),
                'book_id' => $this->book->id
            ]);
            $this->isWishlisted = true;
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Added to wishlist!']);
        }

        $this->dispatch('wishlistUpdated');
    }

    public function render()
    {
        return view('livewire.user.add-to-wishlist');
    }
}
