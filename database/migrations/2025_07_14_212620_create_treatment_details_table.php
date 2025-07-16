<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('treatment_details', function (Blueprint $table) {
            $table->id();
            $table->uuid('reservation_id');
            $table->date('treatment_date');   
            $table->string('campaign')->nullable();
            $table->string('menu')->nullable();
            $table->text('content')->nullable();    
            $table->string('products')->nullable();  
            $table->string('employee')->nullable();  
            $table->string('desired_style')->nullable(); 
            $table->string('hair_and_scalp')->nullable(); 
            $table->string('allergy')->nullable();   
            $table->text('customer_feedback')->nullable(); 
            $table->text('next_proposal')->nullable();   
            $table->text('memo')->nullable();
            $table->timestamps();

            // 外部キー制約
            $table->foreign('reservation_id')
                ->references('reservation_id')
                ->on('reservations')
                ->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatment_details');
    }
};
