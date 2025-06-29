<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'user_id' => 'U' . $this->faker->unique()->numerify('##########'), // LINE ID風
            'phone_number' => $this->faker->phoneNumber(),
        ];
    }
}
