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

    // 予約編集画面
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        $menus = Menu::all();
        $employees = Employee::all();
        $customers = Customer::all();
        return view('reservations.edit', compact('reservation', 'menus', 'employees', 'customers'));
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
}
