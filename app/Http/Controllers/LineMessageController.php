<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\LineMessage;

class LineMessageController extends Controller
{

    public function index()
    {
        $customers = \App\Models\Customer::with(['latestMessage'])
            ->whereHas('messages')
            ->get();

        return view('line.index', compact('customers'));
    }

public function show($customer_id)
{
    $customer = \App\Models\Customer::where('customer_id', $customer_id)->firstOrFail();
    $messages = $customer->messages()->orderBy('sent_at')->get();

    // ここで customer_id を明示的に渡す
    return view('line.message-thread', [
        'customer' => $customer,
        'messages' => $messages,
        'customer_id' => $customer->id, // または $customer_id
    ]);
}


    public function render()
{
    return view('welcome'); // ← Laravel初期画面
}

}
