<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
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
        return [
            'order_number' => fake()->unique()->bothify('SO-#####'),
            'customer_id' => Customer::factory(),
            'customer_name' => fake()->company(),
            'user_id' => User::factory(),
            'status' => fake()->randomElement(['pending', 'confirmed', 'fulfilled', 'cancelled']),
            'order_date' => fake()->dateTimeBetween('-90 days', 'now'),
            'notes' => fake()->optional()->sentence(),
            'subtotal' => 0,
            'discount_total' => 0,
            'tax_total' => 0,
            'total' => 0,
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }
}
