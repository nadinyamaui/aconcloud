<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RelacionesPago extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relaciones_pago', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pago_id');
            $table->unsignedInteger('item_id');
            $table->string('item_type');
            $table->timestamps();

            $table->unique(['pago_id', 'item_id', 'item_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('relaciones_pago');
    }

}
