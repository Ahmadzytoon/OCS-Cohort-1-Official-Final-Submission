<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;

class PerformanceTrendsSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure we have users and products
        if (User::count() == 0)
            User::factory(5)->create();

        // Ensure we have products with prices
        if (Product::count() == 0) {
            // If no products, we can't seed orders properly without creating them first
            // Assuming ProductSeeder exists or we just rely on existing ones.
            // If empty, let's create some dummy ones just in case?
            // User likely has products from previous steps.
        }

        $users = User::all();
        $products = Product::all();

        if ($products->isEmpty()) {
            return;
        }

        // Generate orders for the last 7 days to populate the chart
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);

            // Random number of orders per day (weighted for realism potentially, but random is fine)
            // 3 to 8 orders per day to make the chart look active
            $ordersCount = rand(3, 8);

            for ($j = 0; $j < $ordersCount; $j++) {
                $user = $users->random();

                $order = new Order();
                $order->user_id = $user->id;
                $order->order_number = 'TRD-' . $date->format('Ymd') . '-' . rand(10000, 99999);
                $order->status = 'delivered';
                $order->payment_status = 'paid'; // Critical for revenue chart
                $order->payment_method = 'card';
                $order->shipping_address = '123 Luxury Lane, Amman';
                $order->total_amount = 0; // Calculated below
                $order->created_at = $date->copy()->addHours(rand(8, 22))->addMinutes(rand(0, 59));
                $order->updated_at = $order->created_at;
                $order->save();

                // Add 1-4 items to each order
                $itemCount = rand(1, 4);
                $orderTotal = 0;

                for ($k = 0; $k < $itemCount; $k++) {
                    $product = $products->random();
                    $quantity = rand(1, 2);
                    $price = $product->price;

                    $order->items()->create([
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                    ]);

                    $orderTotal += ($price * $quantity);
                }

                $order->total_amount = $orderTotal;
                $order->save();
            }
        }
    }
}
