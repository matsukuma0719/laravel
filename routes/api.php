<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\WorkShiftController;
use App\Http\Controllers\Api\EmployeeMenuController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\LineWebhookController;
use App\Http\Middleware\AllowOnlySpecificIp;

Route::post('/line/webhook', [LineWebhookController::class, 'webhook']);

Route::middleware(['check.api.key', 'allow.only.specific.ip'])->group(function () {
   
    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::get('/customers', [CustomerController::class, 'index']);
    Route::get('/work_shifts', [WorkShiftController::class, 'index']);
    Route::get('/employeemenu', [EmployeeMenuController::class, 'index']);
    Route::get('/reservations', [ReservationController::class, 'index']);
});

