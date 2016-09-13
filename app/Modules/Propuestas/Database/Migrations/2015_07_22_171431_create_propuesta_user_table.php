<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePropuestaUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propuesta_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('propuesta_id');
            $table->unsignedInteger('user_id');
            $table->unique(['propuesta_id', 'user_id']);

            $table->timestamps();

            $table->foreign('propuesta_id')->references('id')->on('propuestas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('propuesta_user');
    }
}
