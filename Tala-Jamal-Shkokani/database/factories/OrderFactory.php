<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $paymentStatuses = ['unpaid', 'paid', 'refunded'];

        return [
            'user_id' => fake()->numberBetween(1, 10),
            'order_number' => 'ORD-' . strtoupper(fake()->unique()->bothify('??###??')),
            'total_amount' => fake()->randomFloat(2, 50, 500),
            'status' => fake()->randomElement($statuses),
            'payment_status' => fake()->randomElement($paymentStatuses),
            'payment_method' => fake()->randomElement(['card', 'cod', 'paypal']),
            'shipping_address' => fake()->address(),
            'notes' => fake()->optional()->sentence(),
            'created_at' => fake()->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
