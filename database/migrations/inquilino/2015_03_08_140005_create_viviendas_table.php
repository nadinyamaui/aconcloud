<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateViviendasTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('viviendas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipo_vivienda_id', false, true);
            $table->integer('propietario_id', false, true)->nullable();
            $table->string('numero_apartamento');
            $table->string('piso', 10)->nullable();
            $table->string('torre')->nullable();
            $table->decimal('saldo_actual', 65, 2);
            $table->text('comentarios')->nullable();
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
        Schema::drop('viviendas');
    }
}
