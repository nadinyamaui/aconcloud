<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePeriodoJuntaUser extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $centralDb = Config::get('database.connections.app.database');
        Schema::create('periodo_junta_user', function (Blueprint $table) use ($centralDb) {
            $table->increments('id');
            $table->unsignedInteger('periodo_junta_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('cargo_junta_id');
            $table->timestamps();

            $table->foreign('periodo_junta_id')->references('id')->on('periodo_junta');
            $table->foreign('user_id')->references('id')->on($centralDb . '.users');
            $table->foreign('cargo_junta_id')->references('id')->on($centralDb . '.cargos_junta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('periodo_junta_user');
    }
}
