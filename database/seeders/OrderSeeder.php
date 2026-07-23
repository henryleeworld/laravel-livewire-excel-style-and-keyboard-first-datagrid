<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        $customers = Customer::query()->orderBy('id')->get();
        $user = User::query()->firstOrFail();
        $statuses = ['pending', 'confirmed', 'fulfilled', 'fulfilled', 'confirmed', 'cancelled'];

        foreach (range(1, 32) as $index) {
            Order::query()->create([
                'order_number' => 'SO-2026-'.str_pad((string) (100 + $index), 4, '0', STR_PAD_LEFT),
                'customer_id' => $customers[($index - 1) % $customers->count()]->id,
                'customer_name' => $customers[($index - 1) % $customers->count()]->company_name,
                'user_id' => $user->id,
                'status' => $statuses[($index - 1) % count($statuses)],
                'order_date' => now()->subDays(33 - $index)->toDateString(),
                'notes' => $index % 5 === 0 ? 'Deliver before 12:00. Receiving desk has been notified.' : null,
            ]);
        }
    }
}
