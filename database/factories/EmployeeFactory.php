<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EmployeeFactory extends Factory
{
    public function definition(): array
    {
        return [                       // 主キーUUID
            'emp_id' => strtoupper(Str::random(10)),      // 業務用の従業員ID（例：ALPHANUMERIC 10桁）
            'name' => $this->faker->name(),
            'user_id' => 'Uemp' . mt_rand(100000, 999999), // LINEユーザーID風
            'image_id' => 'image_' . mt_rand(1, 100),
            'bio' => $this->faker->sentence(),
            'menu_id' => json_encode([]),                 // 空配列（後で追加できる）
            'role' => 'staff',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

}

