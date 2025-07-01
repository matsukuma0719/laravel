<?php
namespace Database\Seeders;
 
 use Illuminate\Database\Seeder;
 use Illuminate\Support\Facades\DB;
 use Illuminate\Support\Str;
 
 class ReservationSeeder extends Seeder
 {
     public function run(): void
     {
         // 実際に存在するIDを取得
        $menuId = DB::table('menus')->value('menu_id');
        $employeeId = DB::table('employees')->value('emp_id');
        $customerId = DB::table('customers')->value('customer_id');
 
         // データ挿入
      DB::table('reservations')->insert([
    'id' => Str::uuid(), // ← 追加
    'reservation_id' => Str::uuid(),
    'emp_id' => $employeeId,
    'menu_id' => $menuId,
    'customer_id' => $customerId,
    'date' => '2025-07-01',
    'start_time' => '10:00:00',
    'end_time' => '11:00:00',
    'created_at' => now(),
    'updated_at' => now(),
]);
     }
    
 }
