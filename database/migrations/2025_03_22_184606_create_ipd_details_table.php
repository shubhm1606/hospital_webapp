<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ipd_details', function (Blueprint $table) {
            $table->bigIncrements('sno');
            $table->integer('opdnumber')->nullable();
            $table->integer('sr_no')->nullable();
            $table->integer('ipdno')->nullable();
            $table->string('refered_dr')->nullable();
            $table->integer('wordno')->nullable();
            $table->string('wordtype')->nullable();
            $table->integer('ipdamount')->nullable();
            $table->string('ipdamount_type')->nullable();
            $table->date('ipd_date')->nullable();
            $table->time('ipd')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ipd_details');
    }
};
