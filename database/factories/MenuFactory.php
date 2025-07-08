<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MenuFactory extends Factory
{
    public function definition(): array
    {
        return [
       'menu_id' => Str::uuid(),
        'menu_name' => $this->faker->randomElement(['カット', 'カラー', 'パーマ']),
        'duration' => $this->faker->randomElement([30, 60, 90, 120, 180]),
        'price' => $this->faker->numberBetween(2000, 10000),
        ];
    }
}
