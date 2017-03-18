<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ForeignKeysInquilinoTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $centralDb = Config::get('database.connections.app.database');
        Schema::table('viviendas', function (Blueprint $table) use ($centralDb) {
            $table->foreign('tipo_vivienda_id')->references('id')->on('tipo_viviendas');
            $table->foreign('propietario_id')->references('id')->on($centralDb . '.users');
        });

        Schema::table('cuentas', function (Blueprint $table) use ($centralDb) {
            $table->foreign('banco_id')->references('id')->on($centralDb . '.bancos');
        });

        Schema::table('movimientos_cuenta', function (Blueprint $table) use ($centralDb) {
            $table->foreign('cuenta_id')->references('id')->on('cuentas');
            $table->foreign('fondo_id')->references('id')->on('fondos');
            $table->foreign('clasificacion_id')->references('id')->on('clasificacion_ingreso_egreso');
            $table->foreign('movimiento_cuenta_cuota_id')->references('id')->on('movimientos_cuenta');
        });

        Schema::table('user_vivienda', function (Blueprint $table) use ($centralDb) {
            $table->foreign('vivienda_id')->references('id')->on('viviendas');
            $table->foreign('user_id')->references('id')->on($centralDb . '.users');
        });

        Schema::table('fondos', function (Blueprint $table) use ($centralDb) {
            $table->foreign('cuenta_id')->references('id')->on('cuentas');
        });

        Schema::table('gasto_vivienda', function (Blueprint $table) use ($centralDb) {
            $table->foreign('vivienda_id')->references('id')->on('viviendas');
            $table->foreign('gasto_id')->references('id')->on('movimientos_cuenta');
        });

        Schema::table('recibos', function (Blueprint $table) use ($centralDb) {
            $table->foreign('corte_recibo_id')->references('id')->on('corte_recibos');
            $table->foreign('vivienda_id')->references('id')->on('viviendas');
        });

        Schema::table('corte_recibo_fondo', function (Blueprint $table) use ($centralDb) {
            $table->foreign('corte_recibo_id')->references('id')->on('corte_recibos');
            $table->foreign('fondo_id')->references('id')->on('fondos');
        });

        Schema::table('pagos', function (Blueprint $table) use ($centralDb) {
            $table->foreign('vivienda_id')->references('id')->on('viviendas');
            $table->foreign('movimiento_cuenta_id')->references('id')->on('movimientos_cuenta');
        });

        Schema::table('relaciones_pago', function (Blueprint $table) use ($centralDb) {
            $table->foreign('pago_id')->references('id')->on('pagos');
            $table->index('item_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
