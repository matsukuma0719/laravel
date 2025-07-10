<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
Schema::create('work_shifts', function (Blueprint $table) {
    $table->id(); // 自動連番
    $table->uuid('employee_id'); // ← UUIDを格納（他テーブルのemployee_idと接続）
    $table->date('work_date');
    $table->time('start_time');
    $table->time('end_time');
    $table->timestamps();

    // UUIDを参照する外部キー制約（主キーのidではなくemployee_idを参照）
    $table->foreign('employee_id')->references('employee_id')->on('employees')->onDelete('cascade');
});

    }

    public function down(): void
    {
        Schema::dropIfExists('work_shifts');
    }
};

