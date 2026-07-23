<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        $customers = [
            ['company_name' => 'Aster & Pine Hotels', 'contact_name' => 'Marta Silva', 'email' => 'marta@asterpine.example', 'phone' => '+370 612 41001', 'segment' => 'Hospitality'],
            ['company_name' => 'Baltic Table Group', 'contact_name' => 'Jonas Petrauskas', 'email' => 'jonas@baltictable.example', 'phone' => '+370 612 41002', 'segment' => 'Hospitality'],
            ['company_name' => 'Common Ground Market', 'contact_name' => 'Elena Rossi', 'email' => 'elena@commonground.example', 'phone' => '+370 612 41003', 'segment' => 'Retail'],
            ['company_name' => 'Fieldwork Offices', 'contact_name' => 'Lukas Meyer', 'email' => 'lukas@fieldwork.example', 'phone' => '+370 612 41004', 'segment' => 'Corporate'],
            ['company_name' => 'Juniper Pantry', 'contact_name' => 'Sofia Novak', 'email' => 'sofia@juniperpantry.example', 'phone' => '+370 612 41005', 'segment' => 'Retail'],
            ['company_name' => 'Morning Assembly', 'contact_name' => 'Amir Haddad', 'email' => 'amir@morningassembly.example', 'phone' => '+370 612 41006', 'segment' => 'Corporate'],
            ['company_name' => 'North Quay Kitchen', 'contact_name' => 'Inga Jankauskaitė', 'email' => 'inga@northquay.example', 'phone' => '+370 612 41007', 'segment' => 'Hospitality'],
            ['company_name' => 'Sunday Goods Co.', 'contact_name' => 'Noah Williams', 'email' => 'noah@sundaygoods.example', 'phone' => '+370 612 41008', 'segment' => 'Retail'],
        ];

        foreach ($customers as $customer) {
            Customer::query()->create([...$customer, 'active' => true]);
        }
    }
}
