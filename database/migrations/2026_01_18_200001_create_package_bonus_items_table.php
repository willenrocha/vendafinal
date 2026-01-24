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
        Schema::create('package_bonus_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('package_id')
                ->constrained('packages')
                ->cascadeOnDelete();

            // Para o usuário, isso vira saldo de créditos.
            $table->string('credit_type', 20); // likes|views|comments
            $table->unsignedInteger('amount');

            // Opcionalmente, define qual serviço será consumido quando o usuário resgatar.
            $table->foreignId('service_id')
                ->nullable()
                ->constrained('services')
                ->nullOnDelete();

            $table->string('label')->nullable();
            $table->string('subtitle')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['package_id', 'credit_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_bonus_items');
    }
};
