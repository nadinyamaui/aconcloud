<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSmsEnviadosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_enviados', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('inquilino_id');
            $table->unsignedInteger('destinatario_id');
            $table->string('mensaje', 160);
            $table->boolean('ind_reservado')->default(0);
            $table->boolean('ind_enviado')->default(0);
            $table->timestamps();

            $table->foreign('inquilino_id')->references('id')->on('inquilinos');
            $table->foreign('destinatario_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sms_enviados');
    }
}
