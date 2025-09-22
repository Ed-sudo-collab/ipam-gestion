<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('level_program', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->foreignId('level_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['program_id', 'level_id']); // optionnel : éviter les doublons
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('level_program');
    }
};
