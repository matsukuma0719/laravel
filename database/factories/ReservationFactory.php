<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\Customer;
use App\Models\Menu;

class ReservationFactory extends Factory
{
public function definition(): array
{
    return [
        'reservation_id' => Str::uuid(),
        'employee_id' => Employee::inRandomOrder()->value('employee_id'),
        'menu_id' => Menu::inRandomOrder()->value('menu_id'),
        'customer_id' => Customer::inRandomOrder()->value('customer_id'),
        'date' => $this->faker->dateTimeBetween('now', '+7 days')->format('Y-m-d'),
        'start_time' => '10:00:00',
        'end_time' => '11:00:00',
    ];
}
}
