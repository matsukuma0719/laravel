
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
         Schema::create('employeemenu', function (Blueprint $table) {
            $table->uuid('emp_id');
            $table->uuid('menu_id');
             $table->timestamps();

            $table->primary(['emp_id', 'menu_id']);

            $table->foreign('emp_id')
                ->references('emp_id')
                ->on('employees')
                ->onDelete('cascade');

            $table->foreign('menu_id')
                ->references('menu_id')
                ->on('menus')
                ->onDelete('cascade');
         });
     }
 
     /**
      * Reverse the migrations.
      */
     public function down(): void
     {
         Schema::dropIfExists('employeemenu');
     }
 };
