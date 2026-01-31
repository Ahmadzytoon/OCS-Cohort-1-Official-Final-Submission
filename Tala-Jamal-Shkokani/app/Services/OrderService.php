<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\UserBehavior;
use App\Models\LoyaltyPoint;
use App\Models\ScheduledCommunication;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OrderService
{
    public function createOrder($user, $cartItems, $data)
    {
        // 1. Create Order Record
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => Order::generateOrderNumber(),
            'total_amount' => $data['total'],
            'tax_amount' => $data['tax'] ?? 0,
            'shipping_amount' => $data['shipping'] ?? 0,
            'status' => 'pending',
            'payment_status' => $data['payment_method'] === 'card' ? 'pending' : 'pending',
            'payment_method' => $data['payment_method'],
            'shipping_address' => $data['shipping_address_text'],
            'currency' => 'USD',
            'transaction_id' => null,
            'notes' => null,
        ]);

        // 2. Create Order Items
        foreach ($cartItems as $item) {
            // Attempt to resolve product variant
            $variantId = null;
            if (isset($item['color']) || isset($item['size'])) {
                $variant = ProductVariant::where('product_id', $item['id'])
                    ->when(isset($item['color']), fn($q) => $q->where('color', $item['color']))
                    ->when(isset($item['size']), fn($q) => $q->where('size', $item['size']))
                    ->first();
                $variantId = $variant?->id;
            }

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'product_variant_id' => $variantId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['price'] * $item['quantity'],
                'product_name' => $item['name'] ?? 'Product',
                'size' => $item['size'] ?? null,
                'color' => $item['color'] ?? null,
            ]);
        }

        return $order;
    }

    public function finalizeOrder(Order $order)
    {
        $user = $order->user;

        // 1. Update Inventory & User Stats
        $purchasedAesthetics = [];

        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                // Update Product Stats
                $product->increment('discover_score', 50);
                $product->increment('recent_purchases', 1);

                // Decrement Total Stock
                $product->decrement('stock', $item->quantity);

                // Decrement Variant Stock if applicable
                if ($item->product_variant_id) {
                    ProductVariant::where('id', $item->product_variant_id)
                        ->decrement('stock', $item->quantity);
                } elseif ($item->color || $item->size) {
                    ProductVariant::where('product_id', $item->product_id)
                        ->when($item->color, fn($q) => $q->where('color', $item->color))
                        ->when($item->size, fn($q) => $q->where('size', $item->size))
                        ->decrement('stock', $item->quantity);
                }

                if ($product->aesthetic) {
                    $purchasedAesthetics[] = $product->aesthetic;
                }

                // Log User Behavior
                UserBehavior::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'action' => 'purchase',
                    'metadata' => ['order_id' => $order->id]
                ]);
            }
        }

        // 2. Update User Profile
        $user->update([
            'total_spent' => $user->total_spent + $order->total_amount,
            'last_purchase_at' => now(),
            'preferred_aesthetics' => array_unique(array_merge($user->preferred_aesthetics ?? [], $purchasedAesthetics)),
        ]);

        // 3. Loyalty Points
        LoyaltyPoint::create([
            'user_id' => $user->id,
            'points' => intval($order->total_amount),
            'source' => 'purchase',
            'order_id' => $order->id,
            'expires_at' => now()->addYear(),
        ]);

        // 4. Schedule Delivery Update
        ScheduledCommunication::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'type' => 'delivery_update',
            'scheduled_at' => now()->addDay(),
        ]);

        // 5. Send Email
        try {
            Mail::to($user->email)->send(new OrderConfirmation($order));
        } catch (\Exception $e) {
            \Log::error("Mail failed: " . $e->getMessage());
        }

        // 6. Update Order Status
        $order->update(['status' => 'processing']);
    }
}
