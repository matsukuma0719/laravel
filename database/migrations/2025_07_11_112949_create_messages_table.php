<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('user_id'); // LINEのuserId
            $table->text('text')->nullable(); // メッセージ本文
            $table->timestamp('sent_at')->nullable(); // 送信日時
            $table->boolean('is_from_user')->default(true); // 送信元（true=ユーザー、false=Bot）
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
