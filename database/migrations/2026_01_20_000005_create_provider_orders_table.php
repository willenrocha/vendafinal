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
        Schema::create('provider_orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id')->unique();
            $table->string('public_code', 20)->unique();

            // Relacionamentos
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('package_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->foreignId('instagram_profile_id')->constrained()->cascadeOnDelete();

            // Dados do pedido
            $table->integer('quantity');

            // Dados do provedor
            $table->string('provider_order_id')->nullable()->index();
            $table->string('provider_order_status')->nullable();
            $table->decimal('provider_charge', 10, 5)->nullable();
            $table->integer('provider_start_count')->nullable();
            $table->integer('provider_remains')->nullable();
            $table->string('provider_currency', 10)->nullable();
            $table->timestamp('provider_order_sent_at')->nullable();
            $table->timestamp('provider_last_check_at')->nullable();

            $table->timestamps();

            // Índices para performance
            $table->index(['user_id', 'created_at']);
            $table->index('provider_order_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_orders');
    }
};
