<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\WorkShift;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class WorkShiftFactory extends Factory
{
    protected $model = WorkShift::class;

    public function definition(): array
    {
        // 勤務コードをランダムに選ぶ
        $shiftCodes = ['A6', 'B8', 'C4', 'D5', 'E7'];
        $code = $this->faker->randomElement($shiftCodes);

        // 開始時刻マップ
        $baseMap = [
            'A' => 9,
            'B' => 10,
            'C' => 11,
            'D' => 12,
            'E' => 13,
        ];

        $letter = substr($code, 0, 1);
        $duration = (int) substr($code, 1);
        $startHour = $baseMap[$letter];
        $startTime = Carbon::createFromTime($startHour, 0);
        $endTime = (clone $startTime)->addHours($duration);

        return [
            'employee_id' => Employee::inRandomOrder()->first()->employee_id,
            'work_date' => now()->addDays(rand(0, 20))->toDateString(),
            'start_time' => $startTime->format('H:i:s'),
            'end_time' => $endTime->format('H:i:s'),
        ];
    }
}
