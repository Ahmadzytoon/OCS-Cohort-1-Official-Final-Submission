<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Book;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function getCart()
    {
        return Cart::where('user_id', Auth::id())
            ->with('items.book')
            ->first();
    }

    public function calculateTotal($cart)
    {
        $total = 0;
        if ($cart) {
            foreach ($cart->items as $item) {
                if ($item->book) {
                    $total += $this->getItemPrice($item->book) * $item->quantity;
                }
            }
        }
        return $total;
    }

    public function getItemPrice(Book $book)
    {
        if ($book->discount_amount > 0) {
            return $book->discount_type === 'percentage'
                ? $book->price - ($book->price * $book->discount_amount / 100)
                : $book->price - $book->discount_amount;
        }
        return $book->price;
    }

    public function addToCart(Book $book, $quantity = 1)
    {
        $cart = Cart::firstOrCreate(['user_id', Auth::id()]);
        
        $item = CartItem::where('cart_id', $cart->id)
            ->where('book_id', $book->id)
            ->first();

        if ($item) {
            $item->increment('quantity', $quantity);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'book_id' => $book->id,
                'quantity' => $quantity
            ]);
        }
    }
}
