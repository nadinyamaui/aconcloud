<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGastoViviendaTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gasto_vivienda', function (Blueprint $table) {
            $table->integer('vivienda_id', false, true);
            $table->integer('gasto_id', false, true);
            $table->unique(['vivienda_id', 'gasto_id']);
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
        Schema::drop('gasto_vivienda');
    }

}
