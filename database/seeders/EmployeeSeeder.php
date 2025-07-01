<?php
 
 namespace Database\Seeders;
 
 use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
 use Illuminate\Support\Str;
 
 class EmployeeSeeder extends Seeder
 {
     public function run(): void
     {
        DB::table('employees')->insert([
            'emp_id' => Str::uuid(),
             'name' => '山田 太郎',
            'user_id' => 'Uemp' . mt_rand(100000, 999999),
             'image_id' => 'image_001',
             'bio' => 'カットとカラーが得意です！',
            'menu_id' => null,
            'role' => 'staff',
            'created_at' => now(),
            'updated_at' => now(),
         ]);
     }
 }
