<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Menu;
use App\Models\EmployeeMenu;

class EmployeeMenuSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();
        $menus = Menu::all();

        foreach ($employees as $employee) {
            // 各従業員にランダムで2つのメニューを割り当て（重複防止）
            $menus->random(2)->each(function ($menu) use ($employee) {
                EmployeeMenu::firstOrCreate(
                    [
                        'emp_id' => $employee->emp_id,
                        'menu_id' => $menu->menu_id,
                    ],
                    [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            });
        }
    }
}
