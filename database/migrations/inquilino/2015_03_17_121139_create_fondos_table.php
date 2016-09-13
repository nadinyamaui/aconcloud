<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFondosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fondos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cuenta_id', false, true);
            $table->string('nombre', 100);
            $table->decimal('saldo_actual', 65, 2);
            $table->boolean('ind_caja_chica')->default(0);
            $table->decimal('porcentaje_reserva', 5, 2);
            $table->decimal('monto_maximo', 65, 2)->nullable();
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
        Schema::drop('fondos');
    }

}
