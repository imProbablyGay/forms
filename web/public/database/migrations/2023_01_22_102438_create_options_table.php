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
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('q_id');
            $table->text('value')->nullable();
            $table->integer('another')->nullable();

<<<<<<< HEAD:web/public/database/migrations/2023_01_22_102438_create_options_table.php
            $table->foreign('q_id')->references('id')->on('questions');
=======
            $table->index(['q_id']);
>>>>>>> 341092e27bf1f695305aa8d88d9c9d6dc680d7ba:web/public/database/migrations/2023_01_04_102438_create_options_table.php
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('options');
    }
};
