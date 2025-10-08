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
        Schema::create('student_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');

            // Types de documents autorisés
            $table->enum('type_document', [
                'acte_naissance',          // Copie de l'acte de naissance ou jugement supplétif
                'diplome',                 // Copie légalisée du diplôme ou attestation de réussite
                'lettre_motivation',       // Lettre de motivation
                'cv',                      // Curriculum vitae
                'photo',                   // Photo d'identité récente
                'cni',                     // Photocopie de la pièce d'identité
            ]);

            $table->string('path'); // Chemin du fichier stocké
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_documents');
    }
};
