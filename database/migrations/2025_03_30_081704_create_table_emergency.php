<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('emergency', function (Blueprint $table) {
            $table->id();
            $table->enum('emergency', ['yes', 'no']); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emergency');
    }
};

