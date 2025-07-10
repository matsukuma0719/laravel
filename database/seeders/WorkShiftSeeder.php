<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\WorkShift;

class WorkShiftSeeder extends Seeder
{
    public function run(): void
    {
        Employee::all()->each(function ($employee) {
            WorkShift::factory(10)->create([
                'employee_id' => $employee->employee_id,
            ]);
        });
    }
}
