<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Wishlist;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FullUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create the User
        $user = User::updateOrCreate(
            ['email' => 'ttt@chic.co'],
            [
                'name' => 'The Test Traveler',
                'password' => Hash::make('password'),
                'role' => 'user',
                'style_persona' => 'Luxury Clean',
                'primary_aesthetic' => 'luxury',
                'secondary_aesthetic' => 'soft',
                'loyalty_tier' => 'Platinum',
                'total_spent' => 2500,
                'last_purchase_at' => now()->subDays(2),
                'preferred_aesthetics' => ['luxury', 'soft', 'mix'],
            ]
        );

        // Clear existing data to avoid duplicates if re-run
        $user->orders()->delete();
        $user->wishlist()->delete();
        Review::where('user_id', $user->id)->delete();

        // Get some products for the data
        $products = Product::inRandomOrder()->limit(10)->get();
        if ($products->isEmpty()) {
            $this->command->warn('No products found to seed user data. Please run ProductSeeder first.');
            return;
        }

        // 2. Create Wishlist (5 items)
        foreach ($products->slice(0, 5) as $product) {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }

        // 3. Create Orders (3 orders)

        // Order 1: Delivered (Luxury Purchase)
        $order1 = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'total_amount' => 1200,
            'status' => 'delivered',
            'payment_status' => 'paid',
            'payment_method' => 'Credit Card',
            'shipping_address' => 'Luxury Boulevard 123, Fashion City, 11122',
            'notes' => 'Please leave at the concierge.',
            'created_at' => now()->subMonths(1),
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $products[0]->id,
            'quantity' => 1,
            'price' => $products[0]->price,
            'size' => 'M',
            'color' => '#000000',
        ]);

        // Order 2: Processing (Recent Edit)
        $order2 = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'total_amount' => 850,
            'status' => 'processing',
            'payment_status' => 'paid',
            'payment_method' => 'Apple Pay',
            'shipping_address' => 'Luxury Boulevard 123, Fashion City, 11122',
            'created_at' => now()->subDays(5),
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $products[1]->id,
            'quantity' => 1,
            'price' => $products[1]->price,
            'size' => 'L',
            'color' => '#FFFFFF',
        ]);

        // Order 3: Pending (Fresh Acquisition)
        $order3 = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'total_amount' => 450,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => 'Cash on Delivery',
            'shipping_address' => 'Luxury Boulevard 123, Fashion City, 11122',
            'created_at' => now(),
        ]);

        OrderItem::create([
            'order_id' => $order3->id,
            'product_id' => $products[2]->id,
            'quantity' => 2,
            'price' => $products[2]->price,
            'size' => 'S',
            'color' => '#F6A6B2',
        ]);

        // 4. Create Reviews (2 reviews)
        Review::create([
            'user_id' => $user->id,
            'product_id' => $products[0]->id,
            'rating' => 5,
            'comment' => 'Absolutely exquisite! The quality of this piece exceeded my expectations. A true luxury staple.',
            'is_approved' => true,
        ]);

        Review::create([
            'user_id' => $user->id,
            'product_id' => $products[1]->id,
            'rating' => 4,
            'comment' => 'Very elegant design. The fit is perfect for my aesthetic calibration.',
            'is_approved' => false, // One pending review for admin to moderate
        ]);

        // 5. Create Address
        \App\Models\UserAddress::create([
            'user_id' => $user->id,
            'type' => 'Home',
            'area' => 'Fashion District',
            'street_address' => 'Luxury Boulevard 123',
            'building_no' => 'Gem Tower',
            'apartment_no' => 'Penthouse A',
            'phone' => '+962 79 000 0001',
            'is_default' => true,
        ]);

        // 6. Create Payment Method
        \App\Models\UserPaymentMethod::create([
            'user_id' => $user->id,
            'type' => 'Credit Card',
            'provider' => 'Visa',
            'last_four' => '4242',
            'expiry' => '12/28',
            'token' => Str::random(32),
            'is_default' => true,
        ]);

        $this->command->info('Full User ttt@chic.co seeded with orders, wishlist, reviews, address, and payment info!');
    }
}
