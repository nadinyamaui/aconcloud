<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateViviendaUserTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_vivienda', function (Blueprint $table) {
            $table->integer('vivienda_id', false, true);
            $table->integer('user_id', false, true);
            $table->timestamps();
            $table->unique(['vivienda_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vivienda_user');
    }

}
