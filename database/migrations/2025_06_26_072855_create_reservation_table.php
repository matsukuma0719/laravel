<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            // 主キー
            $table->uuid('id')->primary();

            // 外部キー
            $table->uuid('menu_id');
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');

            $table->uuid('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');

            $table->uuid('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

            // 予約詳細
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');

            // 外部連携用の追加UUID（予約番号など）
            $table->uuid('uuid')->unique();

            // タイムスタンプ
            $table->timestamps();

            // 検索最適化用インデックス
            $table->index(['employee_id', 'date', 'start_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
