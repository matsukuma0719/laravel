<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    public function definition(): array
    {
        return [
            'menu_name' => $this->faker->randomElement(['カット', 'カラー', 'パーマ', 'トリートメント']),
            'duration' => $this->faker->randomElement([30, 45, 60, 90, 120, 180]), // 分単位
            'price' => $this->faker->numberBetween(2000, 10000),
        ];
    }
}
