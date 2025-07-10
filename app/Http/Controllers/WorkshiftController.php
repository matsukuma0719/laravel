<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\WorkShift;
use Carbon\Carbon;

class WorkShiftController extends Controller
{
    // ✅ 勤務シフト一覧表示（年月対応）
    public function index(Request $request)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        $start = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $dates = collect();
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $dates->push($date->copy());
        }

        $employees = Employee::with(['workShifts' => function ($query) use ($start, $end) {
            $query->whereBetween('work_date', [$start->toDateString(), $end->toDateString()]);
        }])->get();

        return view('work_shifts.index', compact('employees', 'dates', 'month', 'year'));
    }

    // ✅ 一括保存処理
    public function bulkUpdate(Request $request)
    {
        $shifts = $request->input('work_shifts', []);
    //dd($shifts); // ← 追加して送信データを確認

       foreach ($shifts as $uuid => $dates) {
    $employee = Employee::where('employee_id', $uuid)->first();
    if (!$employee) continue;

    foreach ($dates as $date => $code) {
        if (!$code) continue;

        [$start, $end] = convertCodeToTime($code);

        WorkShift::updateOrCreate(
            ['employee_id' => $employee->employee_id, 'work_date' => $date], // ← `id` に修正
            ['start_time' => $start, 'end_time' => $end]
        );
    }
}

        return redirect()->back()->with('success', '勤務シフトを保存しました');
    }
}
