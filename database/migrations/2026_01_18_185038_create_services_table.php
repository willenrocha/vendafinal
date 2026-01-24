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
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            $table->foreignId('provider_id')
                ->constrained('providers')
                ->cascadeOnDelete();

            // ID do serviço dentro do provedor (campo `service` da API).
            $table->unsignedBigInteger('provider_service_id');

            // Campos "nossos".
            $table->string('name');
            $table->string('social_network', 50)->nullable();
            $table->boolean('is_active')->default(true);

            // Campos espelhados do provedor (para cálculos e auditoria).
            $table->string('provider_name');
            $table->string('provider_type')->nullable();
            $table->string('provider_category')->nullable();
            $table->decimal('provider_rate', 16, 8)->nullable();
            $table->unsignedInteger('provider_min')->nullable();
            $table->unsignedInteger('provider_max')->nullable();
            $table->boolean('provider_refill')->default(false);
            $table->boolean('provider_cancel')->default(false);

            $table->timestamp('provider_synced_at')->nullable();
            $table->text('last_error')->nullable();
            $table->timestamp('last_error_at')->nullable();

            $table->timestamps();

            $table->unique(['provider_id', 'provider_service_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
