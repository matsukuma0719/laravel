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
            'customer_id' => $uuid,      // 外部参照・一意な識別子
            'name' => $this->faker->name(),
            'user_id' => 'U' . $this->faker->unique()->numerify('##########'),
            'phone_number' => $this->faker->phoneNumber(),
        ];
    }
}
