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
        Schema::create('question_types', function (Blueprint $table) {
            $table->id();
            $table->string('type');

<<<<<<< HEAD:web/public/database/migrations/2023_01_23_212301_create_question_types_table.php
=======


>>>>>>> 341092e27bf1f695305aa8d88d9c9d6dc680d7ba:web/public/database/migrations/2023_01_18_212301_create_question_types_table.php
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_types');
    }
};
