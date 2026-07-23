<?php

namespace App\Actions;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateOrder
{
    /**
     * Handle the incoming request.
     */
    public function handle(User $user, Customer $customer, string $orderDate, ?string $notes, array $lines): Order
    {
        return DB::transaction(function () use ($user, $customer, $orderDate, $notes, $lines): Order {
            $products = Product::query()
                ->whereKey(collect($lines)->pluck('product_id')->unique()->all())
                ->get()
                ->keyBy('id');

            $preparedLines = collect($lines)->map(function (array $line) use ($products): array {
                $product = $products->get((int) $line['product_id']);
                $quantity = (int) $line['quantity'];
                $unitPrice = (float) $line['unit_price'];
                $discountPercent = (float) $line['discount_percent'];
                $taxRate = (float) $line['tax_rate'];
                $subtotal = round($quantity * $unitPrice, 2);
                $discountAmount = round($subtotal * $discountPercent / 100, 2);
                $taxAmount = round(($subtotal - $discountAmount) * $taxRate / 100, 2);

                return [
                    'product_id' => $product->id,
                    'sku' => $product->sku,
                    'product_name' => $product->name,
                    'unit' => $product->unit,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'discount_percent' => $discountPercent,
                    'tax_rate' => $taxRate,
                    'subtotal' => $subtotal,
                    'discount_amount' => $discountAmount,
                    'tax_amount' => $taxAmount,
                    'total' => round($subtotal - $discountAmount + $taxAmount, 2),
                ];
            });

            $subtotal = round((float) $preparedLines->sum('subtotal'), 2);
            $discountTotal = round((float) $preparedLines->sum('discount_amount'), 2);
            $taxTotal = round((float) $preparedLines->sum('tax_amount'), 2);

            $order = Order::query()->create([
                'order_number' => 'TMP-'.Str::uuid(),
                'customer_id' => $customer->id,
                'customer_name' => $customer->company_name,
                'user_id' => $user->id,
                'status' => 'pending',
                'order_date' => $orderDate,
                'notes' => filled($notes) ? $notes : null,
                'subtotal' => $subtotal,
                'discount_total' => $discountTotal,
                'tax_total' => $taxTotal,
                'total' => round($subtotal - $discountTotal + $taxTotal, 2),
            ]);

            $order->update([
                'order_number' => 'SO-'.Carbon::parse($orderDate)->format('Y').'-'.str_pad((string) $order->id, 4, '0', STR_PAD_LEFT),
            ]);

            $order->items()->createMany($preparedLines->all());

            return $order->load('items');
        });
    }
}
