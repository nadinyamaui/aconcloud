<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInquilinosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquilinos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 50);
            $table->string('host', 100);
            $table->text('descripcion')->handle();
            $table->string('email_administrador', 100);
            $table->text('direccion')->nullable();
            $table->string('token_acceso', 25)->nullable();
            $table->boolean('ind_configurado')->default(0);
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
        Schema::drop('inquilinos');
    }

}
