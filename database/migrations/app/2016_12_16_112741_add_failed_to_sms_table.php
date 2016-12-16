<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFailedToSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_enviados', function (Blueprint $table) {
            $table->boolean('ind_fallido')->default(false)->after('ind_enviado');
            $table->dropColumn('ind_reservado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sms_enviados', function (Blueprint $table) {
            //
        });
    }
}
