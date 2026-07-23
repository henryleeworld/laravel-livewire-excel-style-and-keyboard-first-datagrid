<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        $products = [
            ['sku' => 'PAN-1001', 'name' => 'Single-origin coffee beans', 'category' => 'Beverages', 'unit' => 'case', 'unit_price' => 68.40, 'tax_rate' => 21, 'stock_quantity' => 84],
            ['sku' => 'PAN-1002', 'name' => 'English breakfast tea', 'category' => 'Beverages', 'unit' => 'box', 'unit_price' => 24.80, 'tax_rate' => 21, 'stock_quantity' => 146],
            ['sku' => 'PAN-1003', 'name' => 'Sparkling mineral water', 'category' => 'Beverages', 'unit' => 'case', 'unit_price' => 17.40, 'tax_rate' => 21, 'stock_quantity' => 228],
            ['sku' => 'PAN-1004', 'name' => 'Cold-pressed apple juice', 'category' => 'Beverages', 'unit' => 'case', 'unit_price' => 31.20, 'tax_rate' => 21, 'stock_quantity' => 96],
            ['sku' => 'DRY-2001', 'name' => 'Stoneground oat flakes', 'category' => 'Pantry', 'unit' => 'case', 'unit_price' => 29.90, 'tax_rate' => 9, 'stock_quantity' => 110],
            ['sku' => 'DRY-2002', 'name' => 'Wildflower honey jars', 'category' => 'Pantry', 'unit' => 'case', 'unit_price' => 54.60, 'tax_rate' => 9, 'stock_quantity' => 72],
            ['sku' => 'DRY-2003', 'name' => 'Extra virgin olive oil', 'category' => 'Pantry', 'unit' => 'case', 'unit_price' => 86.40, 'tax_rate' => 9, 'stock_quantity' => 61],
            ['sku' => 'DRY-2004', 'name' => 'Sea salt flakes', 'category' => 'Pantry', 'unit' => 'box', 'unit_price' => 19.75, 'tax_rate' => 9, 'stock_quantity' => 134],
            ['sku' => 'DRY-2005', 'name' => 'Dark chocolate couverture', 'category' => 'Pantry', 'unit' => 'box', 'unit_price' => 73.20, 'tax_rate' => 9, 'stock_quantity' => 49],
            ['sku' => 'DRY-2006', 'name' => 'Almond granola', 'category' => 'Pantry', 'unit' => 'case', 'unit_price' => 45.80, 'tax_rate' => 9, 'stock_quantity' => 87],
            ['sku' => 'PKG-3001', 'name' => 'Compostable coffee cups', 'category' => 'Packaging', 'unit' => 'case', 'unit_price' => 52.00, 'tax_rate' => 21, 'stock_quantity' => 190],
            ['sku' => 'PKG-3002', 'name' => 'Kraft takeaway bowls', 'category' => 'Packaging', 'unit' => 'case', 'unit_price' => 61.50, 'tax_rate' => 21, 'stock_quantity' => 118],
            ['sku' => 'PKG-3003', 'name' => 'Recycled paper napkins', 'category' => 'Packaging', 'unit' => 'case', 'unit_price' => 38.90, 'tax_rate' => 21, 'stock_quantity' => 205],
            ['sku' => 'PKG-3004', 'name' => 'Glass swing-top bottles', 'category' => 'Packaging', 'unit' => 'case', 'unit_price' => 74.30, 'tax_rate' => 21, 'stock_quantity' => 44],
            ['sku' => 'CLN-4001', 'name' => 'Citrus surface cleaner', 'category' => 'Cleaning', 'unit' => 'case', 'unit_price' => 42.60, 'tax_rate' => 21, 'stock_quantity' => 91],
            ['sku' => 'CLN-4002', 'name' => 'Concentrated dish soap', 'category' => 'Cleaning', 'unit' => 'case', 'unit_price' => 39.80, 'tax_rate' => 21, 'stock_quantity' => 102],
            ['sku' => 'CLN-4003', 'name' => 'Recycled bin liners', 'category' => 'Cleaning', 'unit' => 'box', 'unit_price' => 27.50, 'tax_rate' => 21, 'stock_quantity' => 158],
            ['sku' => 'CLN-4004', 'name' => 'Microfibre cloth set', 'category' => 'Cleaning', 'unit' => 'pack', 'unit_price' => 16.90, 'tax_rate' => 21, 'stock_quantity' => 214],
            ['sku' => 'EQP-5001', 'name' => 'Stainless serving tray', 'category' => 'Equipment', 'unit' => 'unit', 'unit_price' => 48.00, 'tax_rate' => 21, 'stock_quantity' => 36],
            ['sku' => 'EQP-5002', 'name' => 'Insulated beverage urn', 'category' => 'Equipment', 'unit' => 'unit', 'unit_price' => 129.00, 'tax_rate' => 21, 'stock_quantity' => 22],
        ];

        foreach ($products as $product) {
            Product::query()->create([...$product, 'active' => true]);
        }
    }
}
