<?php

// app/Http/Controllers/ReservationController.php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Menu;
use App\Models\Employee;
use App\Models\Customer;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    // 一覧表示
    public function index()
    {
        $reservations = Reservation::with(['menu', 'employee', 'customer'])->paginate(10);
        return view('reservations.index', compact('reservations'));
    }

    // 予約フォーム表示
   /* public function create()
    {
        $menus = Menu::all();
        $employees = Employee::all();
        $customers = Customer::all();
        return view('reservations.create', compact('menus', 'employees', 'customers'));
    }

    // 新規予約登録
    public function store(Request $request)
    {
        $request->validate([
            'emp_id' => 'required',
            'menu_id' => 'required',
            'customer_id' => 'required',
            'date' => 'required|date',
            'start_time' => 'required',
        ]);

        Reservation::create($request->all());

        return redirect()->route('reservations.index')->with('success', '予約を登録しました');
    }
        */

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

    public function today()
    {
        $employees = Employee::all();

        // ✅ 表示時間範囲をセッションから取得（なければデフォルト）
        $startHour = session('start_hour', 8);
        $endHour = session('end_hour', 19);

        // ✅ 今日の予約データを取得してキーを整形
        $reservations = Reservation::where('date', today()->toDateString())->get()
            ->mapWithKeys(function ($r) {
                $formattedTime = \Carbon\Carbon::parse($r->start_time)->format('H:i');
                return [$r->emp_id . '_' . $formattedTime => $r];
            });

        // ✅ Bladeへ全変数を渡す
        return view('reservations.today', compact('employees', 'reservations', 'startHour', 'endHour'));
    }


        public function viewSetting()
    {
        $startHour = session('start_hour', 8);
        $endHour = session('end_hour', 19);

        return view('reservations.view_setting', compact('startHour', 'endHour'));
    }

    public function applyViewSetting(Request $request)
    {
        session([
            'start_hour' => $request->start_hour,
            'end_hour' => $request->end_hour,
        ]);

        return redirect()->route('reservations.today');
    }

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
