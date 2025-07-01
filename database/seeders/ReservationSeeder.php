<?php
 
 namespace Database\Seeders;
 
 use Illuminate\Database\Seeder;
 use Illuminate\Support\Facades\DB;
 use Illuminate\Support\Str;
 
 class ReservationSeeder extends Seeder
 {
     public function run(): void
     {
        $menuId = DB::table('menus')->value('menu_id');
        $employeeId = DB::table('employees')->value('emp_id');
         Ir$customerId = DB::table('customers')->value('customer_id');
 
         // データ挿入
         DB::table('reservations')->insert([
            'reservations_id' => Str::uuid(),
            'emp_id' => $employeeId,
             'menu_id' => $menuId,
             'customer_id' => $customerId,
             'date' => '2025-07-01',
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
             'uuid' => Str::uuid(),
             'created_at' => now(),
             'updated_at' => now(),
         ]);
     }
 }