<?php
 
namespace Database\Seeders;
  use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
 
 class EmployeeMenuSeeder extends Seeder
 {
     /**
      * Run the database seeds.
      */
     public function run(): void
     {
        $menuId = DB::table('menus')->value('menu_id');
        $employeeId = DB::table('employees')->value('emp_id');

        DB::table('employeemenu')->insert([
            'emp_id' => $employeeId,
            'menu_id' => $menuId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
     }
 }
