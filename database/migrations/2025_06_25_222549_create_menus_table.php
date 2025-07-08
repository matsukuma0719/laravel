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
        $table->id()->primary();
        $table->uuid('menu_id')->unique();      // 補助ID（UUID）
        $table->string('menu_name');
        $table->integer('duration');            // 所要時間（分単位）
        $table->integer('price')->nullable();   // 料金（任意）
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
