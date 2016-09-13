<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTipoAyudasTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_ayudas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->timestamps();
        });

        Schema::table('ayudas', function (Blueprint $table) {
            $table->unsignedInteger('tipo_ayuda_id')->after('contenido');
            $table->foreign('tipo_ayuda_id')->references('id')->on('tipo_ayudas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tipo_ayudas');
    }

}
