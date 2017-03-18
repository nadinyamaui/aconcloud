<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComentariosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $centralDb = Config::get('database.connections.app.database');
        Schema::create('comentarios', function (Blueprint $table) use ($centralDb) {
            $table->increments('id');
            $table->unsignedInteger('autor_id');
            $table->unsignedInteger('item_id')->nullable();
            $table->string('item_type');
            $table->text('comentario');
            $table->timestamps();

            $table->foreign('autor_id')->references('id')->on($centralDb . '.users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comentarios');
    }
}
