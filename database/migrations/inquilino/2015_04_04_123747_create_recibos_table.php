<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecibosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('num_recibo', 15);
            $table->integer('corte_recibo_id', false, true);
            $table->integer('vivienda_id', false, true);
            $table->decimal('monto_no_comun', 65, 2);
            $table->decimal('deuda_anterior', 65, 2);
            $table->decimal('porcentaje_mora', 5, 2)->nullable();
            $table->decimal('monto_mora', 65, 2)->nullable();
            $table->enum('estatus', ['GEN', 'PEN', 'VEN', 'PAG']);
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
        Schema::drop('recibos');
    }

}
