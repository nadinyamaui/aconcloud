<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddErrorToSmsEnviados extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_enviados', function (Blueprint $table) {
            $table->string('error')->after('ind_enviado')->nullable();
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
