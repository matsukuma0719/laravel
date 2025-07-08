<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Customer;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
    $uuid = (string) Str::uuid();

        return [
        'customer_id' => Str::uuid(),
        'user_id' => 'U' . Str::random(30), // LINE想定
        'name' => $this->faker->name(),
        'phone_number' => $this->faker->phoneNumber(),
        ];
    }
}
