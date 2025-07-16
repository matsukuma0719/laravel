<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('customer_profile', function (Blueprint $table) {
            $table->id();
            $table->uuid('customer_id');
            $table->string('gender')->nullable();
            $table->date('birthday')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('mail_address')->nullable();
            $table->string('first_visit_date')->nullable();
            $table->string('last_visit_date')->nullable();
            $table->string('numeber_visit_store')->nullable();
            $table->string('memo')->nullable();
            $table->timestamps();
            // 外部キー制約
            $table->foreign('customer_id')
              ->references('customer_id')
              ->on('customers')
              ->onDelete('cascade');
        });
    }

};
