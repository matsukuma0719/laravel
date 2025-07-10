<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  
public function run(): void
{
    // 1. 先に基礎データ（menu, employee, customer）を作成
    \App\Models\Menu::factory(5)->create();
    \App\Models\Employee::factory(5)->create();
    \App\Models\Customer::factory(10)->create();
    \App\Models\Reservation::factory(20)->create();
    $this->call([WorkShiftSeeder::class,]);
}
}
