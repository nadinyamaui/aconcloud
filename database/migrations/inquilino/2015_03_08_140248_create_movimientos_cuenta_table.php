<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMovimientosCuentaTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos_cuenta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cuenta_id', false, true)->nullable();
            $table->integer('fondo_id', false, true)->nullable();
            $table->integer('clasificacion_id', false, true)->nullable();
            $table->string('referencia', 50)->nullable();
            $table->string('numero_factura')->nullable();
            $table->enum('tipo_movimiento', ['ND', 'NC']);
            $table->enum('forma_pago', ['efectivo', 'banco'])->nullable();
            $table->decimal('monto_ingreso', 65, 2)->nullable();
            $table->decimal('monto_egreso', 65, 2)->nullable();
            $table->date('fecha_pago')->nullable();
            $table->date('fecha_factura')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('comentarios')->nullable();
            $table->boolean('ind_gasto_no_comun')->nullable();
            $table->boolean('ind_afecta_calculos')->default(1);
            $table->boolean('ind_movimiento_en_cuotas')->default(0);
            $table->integer('cuota_numero')->nullable();
            $table->integer('total_cuotas')->nullable();
            $table->decimal('porcentaje_cuotas', 5, 2)->nullable();
            $table->decimal('monto_inicial', 65, 2)->nullable();
            $table->unsignedInteger('movimiento_cuenta_cuota_id')->nullable();
            $table->enum('estatus', ['PEN', 'PRO']);
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
        Schema::drop('movimientos_cuenta');
    }

}
