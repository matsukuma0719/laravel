<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'user_id' => 'U' . $this->faker->unique()->numerify('##########'), // LINE ID風
            'image_id' => $this->faker->uuid(), // 画像IDの代用
            'bio' => $this->faker->realText(50), // 自己紹介文
        ];
    }
}

