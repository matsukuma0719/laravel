<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Menu;
use App\Models\Employee;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

//ーーーーーーーーーーーRESERVATIONーーーーーーーーーーーー
class ReservationController extends Controller
{
    

     public function store(Request $request)
    {
        $validated = $request->validate([
            'emp_name'      => 'required|string',
            'date'          => 'required|date',
            'start_time'    => 'required|date_format:H:i',
            'end_time'      => 'required|date_format:H:i',
            'menu_name'     => 'required|string',
            'uuid'          => 'required|uuid',
            'user_id'       => 'required|string',
            'customer_name' => 'required|string',
        ]);

        Reservation::create($validated);

        return response()->json(['status' => 'OK'], 201);
    }


    //ーーーーーーーーーー予約一覧を取得ーーーーーーーーーー
    public function index()
    {
        $reservations = Reservation::with(['employee', 'menu', 'customer'])
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        return view('reservations.index', compact('reservations'));
    }


    // 一覧描画
    public function showTodaySchedule()
    {
        $employees = Employee::all();
        $reservations = Reservation::with(['employee', 'menu'])
            ->whereDate('date', today())
            ->get();

        $timeSlots = [];
        $start = strtotime('09:00');
        $end = strtotime('18:00');

        while ($start < $end) {
            $timeSlots[] = date('H:i', $start);
            $start += 30 * 60;
        }

        return view('reservations.today', compact('employees', 'reservations', 'timeSlots'));
    }


    // 予約更新
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update($request->all());

        return redirect()->route('reservations.index')->with('success', '予約を更新しました');
    }

    // 予約削除
    public function destroy($id)
    {
        Reservation::findOrFail($id)->delete();

        return redirect()->route('reservations.index')->with('success', '予約を削除しました');
    }

    // 今日の予約表示
    public function today()
    {
        $employees = Employee::with([
            'reservations' => function ($query) {
                $query->whereDate('date', today())
                    ->orderBy('start_time');
            }
        ])->get();

        $timeSlots = [];
        $start = \Carbon\Carbon::createFromTime(9, 0);
        $end = \Carbon\Carbon::createFromTime(18, 0);
        while ($start < $end) {
            $timeSlots[] = $start->format('H:i');
            $start->addMinutes(30);
        }

        return view('reservations.today', compact('employees', 'timeSlots'));
    }


    // 表示時間設定画面
    public function viewSetting()
    {
        $startHour = session('start_hour', 8);
        $endHour = session('end_hour', 19);

        return view('reservations.view_setting', compact('startHour', 'endHour'));
    }

    // 表示時間をセッションに保存
    public function applyViewSetting(Request $request)
    {
        session([
            'start_hour' => $request->start_hour,
            'end_hour' => $request->end_hour,
        ]);

        return redirect()->route('reservations.today');
    }

    // 編集画面表示
    public function edit($empId, Request $request)
    {
        $time = $request->query('time');
        $date = today()->toDateString();

        $employee = Employee::findOrFail($empId);
        $reservation = Reservation::where('emp_id', $empId)
            ->where('start_time', $time)
            ->where('date', $date)
            ->first();

        return view('reservations.edit', compact('employee', 'reservation', 'time'));
    }
}
