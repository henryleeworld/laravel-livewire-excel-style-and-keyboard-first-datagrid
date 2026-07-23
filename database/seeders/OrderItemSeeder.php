<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        $products = Product::query()->orderBy('id')->get();

        Order::query()->orderBy('id')->each(function (Order $order) use ($products): void {
            $subtotal = 0.0;
            $discountTotal = 0.0;
            $taxTotal = 0.0;
            $lineCount = 3 + ($order->id % 3);

            foreach (range(0, $lineCount - 1) as $offset) {
                $product = $products[($order->id * 2 + $offset) % $products->count()];
                $quantity = 1 + (($order->id + $offset) % 8);
                $discountPercent = $offset === 2 ? 5 : 0;
                $lineSubtotal = round($quantity * (float) $product->unit_price, 2);
                $discountAmount = round($lineSubtotal * $discountPercent / 100, 2);
                $taxAmount = round(($lineSubtotal - $discountAmount) * (float) $product->tax_rate / 100, 2);

                $order->items()->create([
                    'product_id' => $product->id,
                    'sku' => $product->sku,
                    'product_name' => $product->name,
                    'unit' => $product->unit,
                    'quantity' => $quantity,
                    'unit_price' => $product->unit_price,
                    'discount_percent' => $discountPercent,
                    'tax_rate' => $product->tax_rate,
                    'subtotal' => $lineSubtotal,
                    'discount_amount' => $discountAmount,
                    'tax_amount' => $taxAmount,
                    'total' => round($lineSubtotal - $discountAmount + $taxAmount, 2),
                ]);

                $subtotal += $lineSubtotal;
                $discountTotal += $discountAmount;
                $taxTotal += $taxAmount;
            }

            $order->update([
                'subtotal' => round($subtotal, 2),
                'discount_total' => round($discountTotal, 2),
                'tax_total' => round($taxTotal, 2),
                'total' => round($subtotal - $discountTotal + $taxTotal, 2),
            ]);
        });
    }
}
