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
        Schema::table('payments', function (Blueprint $table) {

            // Supprimer les anciennes dépendances
            $table->dropForeign(['fee_id']);
            $table->dropForeign(['installment_id']);

            $table->dropColumn([
                'fee_id',
                'installment_id',
                'amount_paid',
            ]);

            // Ajouter les nouveaux champs
            $table->decimal('total_amount', 12, 2)->after('payment_method_id');
            $table->string('reference')->nullable()->after('total_amount');
            $table->enum('status', ['CONFIRMED', 'CANCELLED'])
                ->default('CONFIRMED')
                ->after('reference');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {

            $table->foreignId('fee_id')
                ->constrained('tuition_fees')
                ->cascadeOnDelete();

            $table->foreignId('installment_id')
                ->nullable()
                ->constrained('tuition_installments')
                ->nullOnDelete();

            $table->decimal('amount_paid', 10, 2);

            $table->dropColumn(['total_amount', 'reference', 'status']);
        });
    }

};
