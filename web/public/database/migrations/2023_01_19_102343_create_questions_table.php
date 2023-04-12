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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->text('text');
            $table->boolean('is_required');
            $table->unsignedBigInteger('type');

<<<<<<< HEAD:web/public/database/migrations/2023_01_21_102343_create_questions_table.php
            $table->index(['type']);

            $table->foreign('form_id')->on('forms')->references('id');
=======
            $table->foreign('id')->references('q_id')->on('options');
            $table->foreign('type')->references('id')->on('question_types');

            $table->index(['form_id']);
>>>>>>> 341092e27bf1f695305aa8d88d9c9d6dc680d7ba:web/public/database/migrations/2023_01_19_102343_create_questions_table.php
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
};
