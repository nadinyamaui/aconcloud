<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVotacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propuestas_votaciones', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('propuesta_id');
            $table->unsignedInteger('vivienda_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->boolean('ind_en_acuerdo')->nullable();
            $table->string('comentarios')->nullable();
            $table->boolean('ind_cerrado')->default(0);

            $table->timestamps();

            $table->foreign('propuesta_id')->references('id')->on('propuestas');
            $table->foreign('vivienda_id')->references('id')->on('viviendas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('propuestas_votaciones');
    }
}
