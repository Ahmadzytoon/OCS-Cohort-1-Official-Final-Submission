<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            return;
        }

        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $paymentMethods = ['Credit Card', 'Apple Pay', 'Cash on Delivery'];

        foreach ($users as $user) {
            // Give each user 1-3 realistic orders
            $orderCount = rand(1, 3);

            for ($i = 0; $i < $orderCount; $i++) {
                $status = $statuses[array_rand($statuses)];
                $paymentMethod = $paymentMethods[array_rand($paymentMethods)];

                // Get user's default address or a static one
                $address = $user->addresses()->where('is_default', true)->first();
                $addressStr = $address
                    ? "{$address->building_no}, {$address->street_address}, {$address->area}, Amman"
                    : "Luxury Apartment 101, Abdoun, Amman";

                $order = Order::create([
                    'user_id' => $user->id,
                    'order_number' => 'CHIC-' . strtoupper(Str::random(8)),
                    'total_amount' => 0, // Calculated below
                    'status' => $status,
                    'payment_status' => ($status === 'delivered' || $status === 'shipped') ? 'paid' : 'pending',
                    'payment_method' => $paymentMethod,
                    'shipping_address' => $addressStr,
                    'notes' => rand(0, 1) ? 'Please leave at the front desk.' : null,
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);

                // Add 1-4 items to the order
                $itemsCount = rand(1, 4);
                $orderTotal = 0;

                $randomProducts = $products->random($itemsCount);
                foreach ($randomProducts as $product) {
                    $qty = rand(1, 2);
                    $price = $product->price;

                    // Pick a random color/size from the product's actual options
                    $color = count($product->colors ?? []) > 0 ? $product->colors[array_rand($product->colors)] : '#000000';
                    $size = count($product->sizes ?? []) > 0 ? $product->sizes[array_rand($product->sizes)] : 'M';

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'price' => $price,
                        'size' => $size,
                        'color' => $color,
                    ]);

                    $orderTotal += ($price * $qty);
                }

                $order->update(['total_amount' => $orderTotal]);
            }
        }
    }
}
