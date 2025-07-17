<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();

        // 本日の直近5件
        $recentReservations = Reservation::with(['employee', 'menu', 'customer'])
            ->where('date', $today)
            ->orderBy('start_time')
            ->limit(5)
            ->get();

        // 本日の出勤者（work_shiftsテーブルとのリレーションを前提）
        $workEmployees = Employee::whereHas('workShifts', function ($q) use ($today) {
            $q->where('work_date', $today);
        })->get();

        // 全従業員（予約表描画用など）
        $employees = Employee::all();

        // 本日の予約一覧
        $reservations = Reservation::with(['employee', 'menu'])
            ->whereDate('date', $today)
            ->get();

        // タイムスロット生成（9:00〜18:00の30分刻み）
        $timeSlots = [];
        $start = Carbon::createFromTime(9, 0);
        $end = Carbon::createFromTime(18, 0);
        while ($start < $end) {
            $timeSlots[] = $start->format('H:i');
            $start->addMinutes(30);
        }

        return view('dashboard', compact(
            'recentReservations', 'workEmployees',
            'employees', 'reservations', 'timeSlots'
        ));
    }
}
