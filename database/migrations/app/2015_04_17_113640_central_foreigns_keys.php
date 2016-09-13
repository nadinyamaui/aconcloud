<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CentralForeignsKeys extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inquilino_user', function (Blueprint $table) {
            $table->foreign('inquilino_id')->references('id')->on('inquilinos');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('grupo_id')->references('id')->on('grupos');
        });

        Schema::table('inquilino_modulo', function (Blueprint $table) {
            $table->foreign('inquilino_id')->references('id')->on('inquilinos');
            $table->foreign('modulo_id')->references('id')->on('modulos');
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
