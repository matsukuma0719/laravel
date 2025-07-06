<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('emp_id')->unique();   
            $table->string('name');
            $table->string('user_id')->unique()->nullable(); // LINE連携IDなど
            $table->string('image_id')->nullable();
            $table->text('bio')->nullable();
            $table->json('menu_id')->nullable();
            $table->string('role')->default('staff'); // 例: staff / admin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};


