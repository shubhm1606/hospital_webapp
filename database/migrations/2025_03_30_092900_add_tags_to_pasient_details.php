<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pasient_details', function (Blueprint $table) {
            $table->string('tags', 255)->nullable()->after('chargesamount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasient_details', function (Blueprint $table) {
            $table->dropColumn('tags');
        });
    }
};
