<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorteReciboCuentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corte_recibo_cuenta', function (Blueprint $table) {
            $table->unsignedInteger('corte_recibo_id');
            $table->unsignedInteger('cuenta_id');
            $table->decimal('saldo', 65, 2);
            $table->unique(['corte_recibo_id', 'cuenta_id']);
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
        Schema::drop('corte_recibo_cuenta');
    }
}
