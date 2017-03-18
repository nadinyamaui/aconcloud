<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->boolean('ind_activo')->default(1);
            $table->boolean('ind_cambiar_password')->default(1);
            $table->rememberToken();

            $table->boolean('ind_recibir_gastos_creados')->default(1);
            $table->boolean('ind_recibir_gastos_modificados')->default(1);

            $table->boolean('ind_recibir_ingresos_creados')->default(1);
            $table->boolean('ind_recibir_ingresos_modificados')->default(1);

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
        Schema::drop('users');
    }
}
