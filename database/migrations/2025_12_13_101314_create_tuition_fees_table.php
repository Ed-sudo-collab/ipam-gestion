<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tuition_fees', function (Blueprint $table) {
            $table->id();

            $table->foreignId('level_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->decimal('total_amount', 10, 2);
            $table->unsignedInteger('installments');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tuition_fees');
    }
};

