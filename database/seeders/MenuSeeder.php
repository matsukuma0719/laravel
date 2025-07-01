<?php
namespace Database\Seeders;
 
 use Illuminate\Database\Seeder;
 use Illuminate\Support\Str;
 use Illuminate\Support\Facades\DB;
 
 class MenuSeeder extends Seeder
 {
     public function run(): void
     {
        DB::table('menus')->insert([
    [
        'id' => Str::uuid(),
        'menu_id' => Str::uuid(),
        'menu_name' => 'カット',
        'duration' => 60,
        'price' => 4000,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'id' => Str::uuid(),
        'menu_id' => Str::uuid(),
        'menu_name' => 'カラー',
        'duration' => 120,
        'price' => 8000,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'id' => Str::uuid(),
        'menu_id' => Str::uuid(),
        'menu_name' => 'パーマ',
        'duration' => 90,
        'price' => 9000,
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);

     }
 }
