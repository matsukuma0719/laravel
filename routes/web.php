<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
// 必要なら追加のコントローラもここに追記
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LineController;


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // プロフィール関連
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🔽 ここに追加メニュー
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
    Route::get('/line', [LineController::class, 'index'])->name('line.index');
    Route::get('/reservations/today', [ReservationController::class, 'today'])->name('reservations.today');
    Route::get('/reservations/view-setting', [ReservationController::class, 'viewSetting'])
        ->name('reservations.view-setting');
    Route::post('/reservations/apply-view-setting', [ReservationController::class, 'applyViewSetting'])
        ->name('reservations.apply-view-setting');
    Route::get('/reservations/{emp}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('/reservations/{id}', [ReservationController::class, 'update'])->name('reservations.update');

});

require __DIR__.'/auth.php';
