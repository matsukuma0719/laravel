<?php

namespace App\Http\Controllers;

use App\Models\Reservation; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // reservationテーブルの最新10件を取得（必要に応じて調整）
        $reservations =Reservation::with(['menu', 'employee', 'customer'])
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'asc')
            ->limit(10)
            ->get();

        return view('dashboard', ['reservations' => $reservations]);
    }
}

