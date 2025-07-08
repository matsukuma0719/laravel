<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
// database/migrations/xxxx_xx_xx_create_employees_table.php

public function up()
{
    Schema::create('employees', function (Blueprint $table) {
        $table->id(); // auto-increment 主キー
        $table->uuid('employee_id')->unique(); // UUIDで外部参照用
        $table->string('name');
        $table->string('user_id')->unique()->nullable(); // LINEユーザーIDなど
        $table->string('image_id')->nullable();
        $table->text('bio')->nullable();
        $table->json('menu_id')->nullable();
        $table->string('role')->default('staff'); // staff / admin
        $table->timestamps();
    });
}


    public function down(): void {
        Schema::dropIfExists('employees');
    }
};


