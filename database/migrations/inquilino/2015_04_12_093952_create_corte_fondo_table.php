<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCorteFondoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corte_recibo_fondo', function (Blueprint $table) {
            $table->unsignedInteger('corte_recibo_id');
            $table->unsignedInteger('fondo_id');
            $table->decimal('saldo', 65, 2);
            $table->unique(['corte_recibo_id', 'fondo_id']);
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
        Schema::drop('corte_fondo');
    }

}
