<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
// 必要なら追加のコントローラもここに追記
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LineController;
use App\Http\Controllers\WorkShiftController;



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

    //＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
    //＝＝＝＝＝＝RESERVATION＝＝＝＝＝＝＝
    //＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
    //ーーーーーーーーーーーー【INDEX】ーーーーーーーーーーーー
    //予約ー総覧
    Route::get('/reservations',[ReservationController::class,'index'])->name('reservations.index');
    // ② 時刻表示設定フォーム
    Route::get('/reservations/view-setting',[ReservationController::class, 'viewSetting'])->name('reservations.view-setting');
    // ③ 表示範囲設定の保存
    Route::post('/reservations/apply-view-setting',[ReservationController::class, 'applyViewSetting'])->name('reservations.apply-view-setting');
    // ④ 予約編集フォーム
    Route::get('/reservations/{emp}/edit',[ReservationController::class, 'edit'])->name('reservations.edit');
    // ⑤ 予約更新
    Route::put('/reservations/{id}',[ReservationController::class, 'update'])->name('reservations.update');
    
    //ーーーーーーーーーーー【TODAY】ーーーーーーーーーーーー
    // 予約の描画
    
Route::get('/reservations/today', [ReservationController::class, 'showTodaySchedule']);

    // ------------ ダッシュボードなど他ページ ------------
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // 必要に応じて他のリソースルート（customers, employees など）を追加
    // Route::resource('customers', CustomerController::class);

    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
    Route::get('/line', [LineController::class, 'index'])->name('line.index');

    //＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
    //＝＝＝＝＝＝＝CUSTOMER＝＝＝＝＝＝＝＝
    //＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
    //ーーーーーーーーー[INDEX]ーーーーーーーーーーーー
    //顧客総覧
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    
    //ーーーーーーーーー[EDIT]ーーーーーーーーー
    //顧客情報の編集
    Route::get('/customers/{customer_id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    //顧客情報の更新
    Route::put('/customers/{customer_id}', [CustomerController::class, 'update'])->name('customers.update');

    //＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
    //＝＝＝＝＝＝＝EMPLOYEE＝＝＝＝＝＝＝＝
    //＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
    //ーーーーーーーーー[INDEX]ーーーーーーーーーーーー
    //従業員総覧
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');

    //＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
    //＝＝＝＝＝＝＝WORK_SHIFT＝＝＝＝＝＝＝
    //＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
    //ーーーーーーーーー[INDEX]ーーーーーーーーーーーー
    //月毎のページ遷移
    Route::get('/work_shifts', [WorkShiftController::class, 'index'])->name('workshift.index');
    //編集画面遷移
    Route::post('/work_shifts/bulk-update', [WorkShiftController::class, 'bulkUpdate'])->name('workshift.bulkUpdate');



});

require __DIR__.'/auth.php';

