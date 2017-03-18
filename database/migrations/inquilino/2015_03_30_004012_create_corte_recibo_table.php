<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCorteReciboTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corte_recibos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
            $table->enum('mes', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]);
            $table->smallInteger('ano');
            $table->date('fecha_vencimiento');
            $table->decimal('ingresos', 65, 2);
            $table->decimal('gastos_comunes', 65, 2);
            $table->decimal('gastos_no_comunes', 65, 2);
            $table->decimal('total_fondos', 65, 2);
            $table->enum('estatus', ['ELA', 'ACT', 'FIN']);
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
        Schema::drop('corte_recibos');
    }
}
