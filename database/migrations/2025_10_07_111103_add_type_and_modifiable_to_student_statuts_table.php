<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('student_statuts', function (Blueprint $table) {
            $table->string('type')->default('personnalisé'); // 'système' ou 'personnalisé'
            $table->boolean('modifiable')->default(true);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_statuts', function (Blueprint $table) {
            //
        });
    }
};
