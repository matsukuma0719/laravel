<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        // 予約一覧取得例
        $reservations = Reservation::all();
        return response()->json($reservations);
    }

    // 他にもstore, show, update, destroyなど書けます
}
