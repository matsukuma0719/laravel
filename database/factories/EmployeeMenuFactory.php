<?php

namespace Database\Factories;

use App\Models\EmployeeMenu;
use App\Models\Employee;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeMenuFactory extends Factory
{
    protected $model = EmployeeMenu::class;

    public function definition(): array
    {
        return [
        'employee_id' => Str::uuid(),
        'menu_id' => Str::uuid(),    
        ];
    }
}
