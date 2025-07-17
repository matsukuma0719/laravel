<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
// 必要なら追加のコントローラもここに追記
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\WorkShiftController;
use App\Http\Controllers\LineMessageController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RichMenuController;


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


    //＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
    //＝＝＝＝＝＝＝CUSTOMER＝＝＝＝＝＝＝＝
    //＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
    //ーーーーーーーーー[INDEX]ーーーーーーーーーーーー
    //顧客総覧
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    
    //ーーーーーーーーー[EDIT]ーーーーーーーーー
    Route::get('/customers/{customer_id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    //顧客情報の更新
    Route::put('/customers/{customer_id}', [CustomerController::class, 'update'])->name('customers.update');

    //＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
    //＝＝＝＝＝＝＝EMPLOYEE＝＝＝＝＝＝＝＝
    //＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
    //ーーーーーーーーー[INDEX]ーーーーーーーーーーーー
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');

    //＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
    //＝＝＝＝＝＝＝WORK_SHIFT＝＝＝＝＝＝＝
    //＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
    //ーーーーーーーーー[INDEX]ーーーーーーーーーーーー
    Route::get('/work_shifts', [WorkShiftController::class, 'index'])->name('work_shifts.index');
    //編集画面遷移
    Route::post('/work_shifts/bulk-update', [WorkShiftController::class, 'bulkUpdate'])->name('work_shifts.bulkUpdate');

    //＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
    //＝＝＝＝＝＝＝MENU＝＝＝＝＝＝＝＝＝＝
    //＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
    //ーーーーーーーーー[INDEX]ーーーーーーーーーーーー
    // メニュー一覧
    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
    // メニュー詳細（必要なら）
    Route::get('/menus/{menu}', [MenuController::class, 'show'])->name('menus.show');
    // メニュー作成（管理用）
    Route::get('/menus/create', [MenuController::class, 'create'])->name('menus.create');
    Route::post('/menus', [MenuController::class, 'store'])->name('menus.store');
    // メニュー編集（管理用）
    Route::get('/menus/{menu}/edit', [MenuController::class, 'edit'])->name('menus.edit');
    Route::put('/menus/{menu}', [MenuController::class, 'update'])->name('menus.update');
    // メニュー削除
    Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');

    //＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
    //＝＝＝＝＝＝＝LINE＝＝＝＝＝＝＝＝＝＝
    //ーーーーーーーーー[INDEX]ーーーーーーーーーーーー
    //webhook記述はapi.phpにinde
    // 一覧ページ（uuid不要）
    Route::get('/line', [LineMessageController::class, 'index'])->name('line.index');
    // 顧客個別ページ
    //Route::get('/line/{customer_id}', [LineMessageController::class, 'show'])->name('line.messages.index');
    //richmenu設定
     Route::prefix('line/richmenu')->group(function () {
    Route::get('/create', [RichMenuController::class, 'create'])->name('richmenu.create');
    Route::post('/store', [RichMenuController::class, 'store'])->name('richmenu.store');
});

});

require __DIR__.'/auth.php';

