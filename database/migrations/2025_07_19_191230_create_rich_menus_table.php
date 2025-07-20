<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rich_menus', function (Blueprint $table) {
            $table->id();
            // $table->uuid('uuid')->unique(); // 必要であれば
            $table->string('title');
            $table->json('genders')->nullable();
            $table->json('ages')->nullable();
            $table->string('preset')->nullable();
            $table->json('areas')->nullable();
            $table->string('image_path')->nullable();
            $table->string('richmenu_id')->nullable(); // ← LINEのリッチメニューID用
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('rich_menus');
    }
};
