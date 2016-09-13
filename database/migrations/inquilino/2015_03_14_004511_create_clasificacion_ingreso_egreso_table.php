<?php

use App\Models\Inquilino\ClasificacionIngresoEgreso;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClasificacionIngresoEgresoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clasificacion_ingreso_egreso', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo', 20)->nullable();
            $table->string('nombre');
            $table->integer('dia_estimado')->nullable();
            $table->boolean('ind_fijo')->default(1);
            $table->decimal('monto', 65, 2)->nullable();
            $table->boolean('ind_egreso')->default(1);
            $table->boolean('ind_bloqueado')->default(0);

            $table->timestamps();
        });

        ClasificacionIngresoEgreso::create([
            'nombre'        => 'Reposición de caja chica',
            'ind_egreso'    => true,
            'ind_bloqueado' => true,
            'ind_fijo'      => false,
            'codigo'        => 'cajachica',
        ]);

        ClasificacionIngresoEgreso::create([
            'nombre'        => 'Cuota de Aconcloud',
            'ind_egreso'    => true,
            'ind_bloqueado' => true,
            'ind_fijo'      => true,
            'codigo'        => 'aconcloud',
        ]);

        ClasificacionIngresoEgreso::create([
            'nombre'        => 'Pago de recibos',
            'ind_egreso'    => false,
            'ind_bloqueado' => true,
            'ind_fijo'      => false,
            'codigo'        => 'pago.recibos',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clasificacion_gastos');
    }

}
