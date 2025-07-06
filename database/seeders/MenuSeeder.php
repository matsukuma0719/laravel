<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // UUIDを事前に生成（menu_id のみに使用）
        $menuId1 = Str::uuid();
        $menuId2 = Str::uuid();
        $menuId3 = Str::uuid();

        DB::table('menus')->insert([
            [
                'menu_id' => $menuId1,
                'menu_name' => 'カット',
                'duration' => 60,
                'price' => 4000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_id' => $menuId2,
                'menu_name' => 'カラー',
                'duration' => 120,
                'price' => 8000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_id' => $menuId3,
                'menu_name' => 'パーマ',
                'duration' => 90,
                'price' => 9000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
// 