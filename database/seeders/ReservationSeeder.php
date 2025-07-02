<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        // 1人の顧客に対して10日間分の予約を作成
        Reservation::factory()->count(10)->create();
    }
}
