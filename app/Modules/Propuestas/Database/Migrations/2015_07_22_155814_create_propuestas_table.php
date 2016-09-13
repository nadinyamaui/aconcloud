<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePropuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propuestas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('asamblea_id')->nullable();
            $table->unsignedInteger('autor_id');
            $table->string('titulo');
            $table->text('propuesta');
            $table->date('fecha_cierre');
            $table->enum('estatus', ['abierta', 'en_discusion', 'en_votacion', 'cerrada']);
            $table->boolean('ind_enviar_sms');
            $table->boolean('ind_enviar_email');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('propuestas');
    }
}
