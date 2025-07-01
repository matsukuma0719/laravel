<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('reservations', function (Blueprint $table) {
    // ✅ 主キー：内部ID（UUID）
    $table->uuid('id')->primary();

    // ✅ 補助ID：予約番号など（表示用・検索用）
    $table->string('reservation_id')->unique(); // 例: RSV00001

    // ✅ 外部キー
    $table->uuid('menu_id');
    $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');

    $table->uuid('employee_id');
    $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');

    $table->uuid('customer_id');
    $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

    // ✅ 予約詳細
    $table->date('date');
    $table->time('start_time');
    $table->time('end_time');

    // ✅ 外部システム連携用UUID（例：LINE予約連携など）
    $table->uuid('uuid')->unique();

    // ✅ タイムスタンプ
    $table->timestamps();

    // ✅ インデックス最適化
    $table->index(['employee_id', 'date', 'start_time']);
});

    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
