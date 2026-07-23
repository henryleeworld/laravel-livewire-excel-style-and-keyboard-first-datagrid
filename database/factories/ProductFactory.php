<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sku' => fake()->unique()->bothify('SKU-####'),
            'name' => fake()->words(3, true),
            'category' => fake()->randomElement(['Pantry', 'Beverages', 'Packaging', 'Cleaning']),
            'unit' => fake()->randomElement(['case', 'box', 'pack', 'unit']),
            'unit_price' => fake()->randomFloat(2, 4, 180),
            'tax_rate' => fake()->randomElement([9, 21]),
            'stock_quantity' => fake()->numberBetween(10, 800),
            'active' => true,
        ];
    }
}
