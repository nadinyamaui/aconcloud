<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAsambleasAsambleasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asambleas_asambleas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo', 100);
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->string('youtube_link')->nullable();
            $table->enum('estatus', ['pendiente', 'en_curso', 'terminada'])->default('pendiente');

            $table->unsignedInteger('autor_id');
            $table->boolean('ind_enviar_sms');
            $table->boolean('ind_enviar_email');

            $table->boolean('ind_notificacion_manana')->default(0);
            $table->boolean('ind_notificacion_preparacion')->default(0);
            $table->boolean('ind_notificacion_inicio')->default(0);

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
        Schema::drop('asambleas_asambleas');
    }
}
