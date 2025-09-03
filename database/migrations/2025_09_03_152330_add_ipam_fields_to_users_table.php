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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nom_utilisateur', 50)->after('name');
            $table->enum('type_utilisateur', ['INTERNE','ETUDIANT'])->default('INTERNE')->after('nom_utilisateur');
            $table->enum('statut', ['ACTIF','INACTIF','BLOQUE'])->default('ACTIF')->after('type_utilisateur');
            $table->timestamp('dernier_login')->nullable()->after('statut');
            $table->dateTime('date_creation')->useCurrent()->after('statut'); // Pour correspondre à date_creation
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
