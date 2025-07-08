
 <?php
 
 use Illuminate\Database\Migrations\Migration;
 use Illuminate\Database\Schema\Blueprint;
 use Illuminate\Support\Facades\Schema;
 
 return new class extends Migration
 {
     /**
      * Run the migrations.
      */
// ✅ migration: create_employeemenu_table.php
public function up(): void
{
    Schema::create('employeemenu', function (Blueprint $table) {
        $table->uuid('employee_id');
        $table->uuid('menu_id');
        $table->timestamps();

        $table->primary(['employee_id', 'menu_id']);

        $table->foreign('employee_id')
            ->references('employee_id')
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
