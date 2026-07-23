<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 20);
        $unitPrice = fake()->randomFloat(2, 5, 150);
        $discountPercent = fake()->randomElement([0, 0, 5, 10]);
        $taxRate = fake()->randomElement([9, 21]);
        $subtotal = round($quantity * $unitPrice, 2);
        $discountAmount = round($subtotal * $discountPercent / 100, 2);
        $taxAmount = round(($subtotal - $discountAmount) * $taxRate / 100, 2);

        return [
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'sku' => fake()->unique()->bothify('SKU-####'),
            'product_name' => fake()->words(3, true),
            'unit' => fake()->randomElement(['case', 'box', 'pack', 'unit']),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'discount_percent' => $discountPercent,
            'tax_rate' => $taxRate,
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'tax_amount' => $taxAmount,
            'total' => round($subtotal - $discountAmount + $taxAmount, 2),
        ];
    }
}
