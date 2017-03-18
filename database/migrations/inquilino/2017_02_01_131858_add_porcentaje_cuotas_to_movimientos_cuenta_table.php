<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPorcentajeCuotasToMovimientosCuentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimientos_cuenta', function (Blueprint $table) {
            $table->decimal('porcentaje_cuotas', 5, 2)->nullable()->after('total_cuotas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movimientos_cuenta', function (Blueprint $table) {
            //
        });
    }
}
