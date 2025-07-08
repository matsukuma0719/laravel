<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
// ✅ migration: create_reservations_table.php
public function up(): void
{
    Schema::create('reservations', function (Blueprint $table) {
        $table->id()->primary();

        // 補助キー（外部連携用UUID）
        $table->uuid('reservation_id')->unique();

        // 外部キー
        $table->uuid('employee_id');
        $table->uuid('menu_id');
        $table->uuid('customer_id');

        $table->foreign('employee_id')->references('employee_id')->on('employees')->onDelete('cascade');
        $table->foreign('menu_id')->references('menu_id')->on('menus')->onDelete('cascade');
        $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');

        // 予約詳細
        $table->date('date');
        $table->time('start_time');
        $table->time('end_time');

        // タイムスタンプ
        $table->timestamps();

        // インデックス
        $table->index(['employee_id', 'date', 'start_time']);
    });
}

public function down(): void
{
    Schema::dropIfExists('reservations');
}
};
