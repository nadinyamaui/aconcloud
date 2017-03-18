<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAlarmasTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alarmas', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime("fecha_vencimiento")->nullable();
            $table->dateTime("fecha_advertencia")->nullable();
            $table->string("nombre", 50);
            $table->text("descripcion")->nullable();
            $table->string("link_handle");
            $table->unsignedInteger('item_id')->nullable();
            $table->string('item_type')->nullable();
            $table->boolean('ind_atendida')->default(0);
            $table->boolean('ind_automatica')->default(0);

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
        Schema::drop('alarmas');
    }
}
