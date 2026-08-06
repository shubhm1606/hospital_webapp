<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasient_details', function (Blueprint $table) {
            $table->bigIncrements('sno')->unsigned();
            $table->integer('sr');
            $table->integer('opdId')->nullable();
            $table->date('pdate')->nullable();
            $table->time('ptime')->nullable();
            $table->string('pesientname', 255)->nullable();
            $table->string('gender', 255)->nullable();
            $table->integer('age')->nullable();
            $table->string('ymd', 255)->nullable();
            $table->string('fatherhusband', 255)->nullable();
            $table->string('mobileno', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('area', 255)->nullable();
            $table->string('caste', 255)->nullable();
            $table->string('desease', 255)->nullable();
            $table->string('mlc_pmlc', 255)->nullable();
            $table->string('charges', 255)->nullable();
            $table->string('chargesamount', 255)->nullable();
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
        Schema::dropIfExists('pasient_details');
    }
};
