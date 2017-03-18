<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConfiguracionTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preferencias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('variable');
            $table->text('valor');
            $table->timestamps();
        });

        \App\Models\Inquilino\Preferencia::create(['variable' => 'dia_corte_recibo', 'valor' => '1']);
        \App\Models\Inquilino\Preferencia::create(['variable' => 'ano_inicio', 'valor' => '2014']);
        \App\Models\Inquilino\Preferencia::create(['variable' => 'mes_inicio', 'valor' => '1']);
        \App\Models\Inquilino\Preferencia::create(['variable' => 'porcentaje_morosidad', 'valor' => '1']);
        \App\Models\Inquilino\Preferencia::create(['variable' => 'inicio_morosidad', 'valor' => '1']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('configuracion');
    }
}
