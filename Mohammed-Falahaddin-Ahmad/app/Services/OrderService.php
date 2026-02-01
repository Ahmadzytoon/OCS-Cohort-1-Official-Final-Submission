<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\Book;
use App\Models\Earning;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function placeOrder(array $data, $cart, $total, $discount = 0)
    {
        return DB::transaction(function () use ($data, $cart, $total, $discount) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total - $discount,
                'shipping_address' => $data['address'],
                'phone' => $data['phone'],
                'order_status' => 'pending',
                'order_number' => 'ORD-' . strtoupper(uniqid()),
            ]);

            foreach ($cart->items as $item) {
                $price = (new CartService())->getItemPrice($item->book);
                
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $item->book_id,
                    'quantity' => $item->quantity,
                    'price' => $price,
                ]);

                // Update stock and sales count
                $item->book->decrement('stock_quantity', $item->quantity);
                $item->book->increment('sales_count', $item->quantity);

                // Handle Author Earnings
                if ($item->book->author) {
                    $commission = ($price * $item->quantity) * 0.10; // 10% platform commission example
                    $earningAmount = ($price * $item->quantity) - $commission;
                    
                    Earning::create([
                        'author_id' => $item->book->author->user_id, // This is the User ID for earnings
                        'order_item_id' => $orderItem->id,
                        'amount' => $earningAmount,
                        'platform_commission' => $commission,
                    ]);

                    $item->book->author->increment('total_earnings', $earningAmount);
                }
            }

            // Create Payment placeholder
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $data['payment_method'],
                'payment_status' => 'pending',
                'transaction_id' => $data['transaction_id'] ?? null,
                'amount' => $total - $discount,
            ]);

            // Clear Cart
            $cart->items()->delete();
            
            return $order;
        });
    }
}
