<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EmployeeFactory extends Factory
{
public function definition(): array
{
    return [
        'employee_id' => Str::uuid(),
        'name' => $this->faker->name(),
        'user_id' => 'U' . Str::random(30), // LINEのユーザーIDを想定
        'image_id' => Str::random(16), // Google DriveのファイルIDなど
        'bio' => $this->faker->text(100),
        'menu_id' => json_encode([1, 2, 3]), // メニューIDをJSONで
        'role' => 'staff',
    ];
}

}

