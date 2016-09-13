<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTipoViviendasTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_viviendas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('cantidad_apartamentos');
            $table->decimal('porcentaje_pago', 8, 6);
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
        Schema::drop('tipo_viviendas');
    }

}
