<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_counters', function (Blueprint $table) {
            $table->string('name')->primary();
            $table->unsignedInteger('current_value')->default(0);
            $table->timestamps();
        });

        DB::table('document_counters')->insert([
            ['name' => 'opd', 'current_value' => (int) DB::table('pasient_details')->max('opdId'), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'opd_serial', 'current_value' => (int) DB::table('pasient_details')->max('sr'), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ipd', 'current_value' => (int) DB::table('ipd_details')->max('ipdno'), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ipd_serial', 'current_value' => (int) DB::table('ipd_details')->max('sr_no'), 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('document_counters');
    }
};