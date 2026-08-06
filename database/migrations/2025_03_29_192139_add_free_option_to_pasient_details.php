<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('pasient_details', function (Blueprint $table) {
            $table->string('free_option', 255)->nullable()->after('chargesamount');
        });
    }

    public function down()
    {
        Schema::table('pasient_details', function (Blueprint $table) {
            $table->dropColumn('free_option');
        });
    }
};
