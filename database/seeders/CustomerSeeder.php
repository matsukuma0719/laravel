<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        // Factoryで10件生成
        Customer::factory()->count(10)->create();
    }
}
