<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        // Factoryで5件作成
        Employee::factory()->count(5)->create();

        // 手動で1件追加
        DB::table('employees')->insert([
            'id' => Str::uuid(), // ← ✅ 必須！
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
