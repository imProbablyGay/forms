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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('name');
<<<<<<< HEAD:web/public/database/migrations/2023_01_20_102324_create_forms_table.php
            $table->timestamps();
            $table->boolean('deleted');
            $table->string('hash');
=======
            $table->foreign('id')->on('questions')->references('form_id');
>>>>>>> 341092e27bf1f695305aa8d88d9c9d6dc680d7ba:web/public/database/migrations/2023_01_17_102324_create_forms_table.php
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forms');
    }
};
