<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\Menu;
use App\Models\Employee;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition(): array
    {
        // 既存データからランダムに選ぶ
        $menu = Menu::inRandomOrder()->first();
        $employee = Employee::inRandomOrder()->first();
        $customer = Customer::first(); // 1人の顧客を対象とする

        if (!$menu || !$employee || !$customer) {
            throw new \Exception('Menu, Employee, または Customer が存在しません。');
        }

        // 本日から10日間の範囲で日付をランダムに選択
        static $dayOffset = 0;
        $date = now()->addDays($dayOffset++)->format('Y-m-d');

        // ランダムな開始時刻（9時〜17時）
        $startHour = $this->faker->numberBetween(9, 17);
        $start_time = sprintf('%02d:00:00', $startHour);

        // メニュー所要時間から終了時刻を算出
        $duration = intval($menu->duration ?? 60); // 分
        $end_time = date('H:i:s', strtotime("+$duration minutes", strtotime($start_time)));

        return [
            'id' => (string) Str::uuid(),
            'reservation_id' => (string) Str::uuid(),
            'emp_id' => $employee->emp_id,
            'menu_id' => $menu->menu_id,
            'customer_id' => $customer->customer_id,
            'date' => $date,
            'start_time' => $start_time,
            'end_time' => $end_time,
        ];
    }
}
