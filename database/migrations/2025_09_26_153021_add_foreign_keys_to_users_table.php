<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // ajouter la contrainte seulement si student_id existe déjà
            if (Schema::hasColumn('users', 'student_id')) {
                $table->foreign('student_id')
                      ->references('id')
                      ->on('students')
                      ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
        });
    }
};
