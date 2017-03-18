<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAlarmaUserTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $centralDb = Config::get('database.connections.app.database');
        Schema::create('alarma_user', function (Blueprint $table) use ($centralDb) {
            $table->unsignedInteger('alarma_id');
            $table->unsignedInteger('user_id');

            $table->primary(['alarma_id', 'user_id']);

            $table->foreign('alarma_id')->references('id')->on('alarmas');
            $table->foreign('user_id')->references('id')->on($centralDb . '.users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('alarma_user');
    }
}
