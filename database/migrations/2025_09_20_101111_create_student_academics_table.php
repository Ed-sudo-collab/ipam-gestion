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
        Schema::create('student_academics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('dernier_diplome')->nullable();
            $table->string('etablissement')->nullable();
            $table->year('annee_obtention')->nullable();
            $table->string('mention')->nullable();
            $table->string('path_diplome')->nullable();
            $table->string('path_releves')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_academics');
    }
};
