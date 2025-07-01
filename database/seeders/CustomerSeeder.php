<?php
 
 namespace Database\Seeders;
 
 use Illuminate\Database\Seeder;
 use Illuminate\Support\Facades\DB;
 use Illuminate\Support\Str;
 
 class CustomerSeeder extends Seeder
 {
     public function run(): void
     {
        DB::table('customers')->insert([
            'customer_id' => Str::uuid(),
            'user_id' => 'U' . mt_rand(1000000000, 9999999999),
            'name' => 'Dr. Deron Harvey IV',
            'phone_number' => '1-985-252-8310',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
     }
 }
