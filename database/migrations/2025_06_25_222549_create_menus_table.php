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
        Schema::create('menus', function (Blueprint $table) {
        $table->uuid('id')->primary(); // ✅ 必須
        $table->string('menu_id')->unique(); // 補助ID 
        $table->string('menu_name');
        $table->integer('duration'); // 分単位
        $table->integer('price')->nullable(); // 任意なのでnullableに
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
