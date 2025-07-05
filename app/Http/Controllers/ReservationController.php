<?php

namespace App\Http\Controllers;

// app/Http/Controllers/ReservationController.php

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['customer', 'employee', 'menu'])->orderBy('date')->orderBy('start_time')->get();
        return view('reservations.index', compact('reservations'));
    }
}
