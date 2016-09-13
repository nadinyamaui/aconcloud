<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInquilinoUserTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquilino_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inquilino_id', false, true);
            $table->integer('user_id', false, true);
            $table->integer('grupo_id', false, true);
            $table->timestamps();

            $table->unique(['inquilino_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('inquilino_user');
    }

}
