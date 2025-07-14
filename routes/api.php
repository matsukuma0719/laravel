<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\WorkShiftController;
use App\Http\Controllers\Api\EmployeeMenuController;
use App\Http\Controllers\Api\ReservationController;

Route::middleware('allow.only.specific.ip')->group(function () {
    Route::get('/check-ip', function (\Illuminate\Http\Request $request) {
        return response()->json(['ip' => $request->ip()]);
    });
});
