<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        Employee::create([
            'id' => Str::uuid(), // ← 明示的にUUIDを指定！
            'emp_id' => 'E001',   // ✅ ← これを追加
            'name' => '山田 太郎',
            'user_id' => 'Uemp0001',
            'image_id' => 'image_001',
            'bio' => 'カットとカラーが得意です！',
        ]);
    }
}
