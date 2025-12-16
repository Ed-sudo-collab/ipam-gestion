<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tuition_installments', function (Blueprint $table) {
            $table->id();

            // Relation avec tuition_fees
            $table->foreignId('tuition_fee_id')
                  ->constrained('tuition_fees')
                  ->cascadeOnDelete();

            // Données métier
            $table->string('label'); // ex: "1ère tranche", "2ème tranche"
            $table->decimal('amount', 10, 2);
            $table->date('due_date');

            $table->timestamps();

            // Index utiles (performance)
            $table->index('due_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tuition_installments');
    }
};
