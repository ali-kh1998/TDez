<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('theater_id');
            $table->unsignedBigInteger('class_id'); 
            $table->unsignedBigInteger('cost');
            $table->timestamps();

            $table->foreign('theater_id')->references('id')->on('theaters');
            $table->foreign('class_id')->references('id')->on('classes');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
};