<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('vivienda_id');
            $table->unsignedInteger('movimiento_cuenta_id');
            $table->decimal('monto_pagado', 65, 2);
            $table->decimal('total_relacion', 65, 2);
            $table->enum('estatus', ['PEN', 'PRO', 'DEV'])->default("PEN");
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
        Schema::drop('pagos');
    }
}
