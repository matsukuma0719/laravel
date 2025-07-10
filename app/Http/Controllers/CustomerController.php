<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
public function index()
{
    $customers = Customer::with('latestReservation')->get();
    return view('customers.index', compact('customers'));
}

// 編集画面の表示
public function edit($customer_id)
{
    $customer = Customer::where('customer_id', $customer_id)->firstOrFail();
    return view('customers.edit', compact('customer'));
}

// 更新処理
public function update(Request $request, $customer_id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone_number' => 'nullable|string|max:20',
    ]);

    $customer = Customer::where('customer_id', $customer_id)->firstOrFail();
    $customer->update([
        'name' => $request->name,
        'phone_number' => $request->phone_number,
    ]);

    return redirect()->route('customers.index')->with('success', '顧客情報を更新しました。');
}


}
