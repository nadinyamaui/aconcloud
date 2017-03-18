<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMensajariaMensajesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $centralDb = Config::get('database.connections.app.database');
        Schema::create('mensajeria_mensajes', function (Blueprint $table) use ($centralDb) {
            $table->increments('id');
            $table->string('asunto', 255);
            $table->longText('cuerpo')->nullable();
            $table->string('cuerpo_sms', 140)->nullable();
            $table->unsignedInteger('destinatario_id');
            $table->unsignedInteger('remitente_id');
            $table->boolean('ind_leido')->default(0);
            $table->boolean('ind_automatico')->default(0);
            $table->boolean('ind_saliente')->default(0);
            $table->boolean('ind_sms')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('destinatario_id')->references('id')->on($centralDb . '.users');
            $table->foreign('remitente_id')->references('id')->on($centralDb . '.users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mensajeria_mensajes');
    }
}
