<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('customer_id')->unique();      // ✅ 補助ID：顧客番号など（表示/検索用）
            $table->string('user_id')->unique();          // ✅ LINEなどの外部連携用ID
            $table->string('name')->nullable();           // 名前
            $table->string('phone_number')->nullable();   // 電話番号
            $table->timestamps();                         // 作成・更新日時
});
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
