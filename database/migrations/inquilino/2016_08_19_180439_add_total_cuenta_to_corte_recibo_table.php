<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalCuentaToCorteReciboTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('corte_recibos', function (Blueprint $table) {
            $table->decimal('total_cuentas', 65, 2)->after('total_fondos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('corte_recibos', function (Blueprint $table) {
        });
    }
}
