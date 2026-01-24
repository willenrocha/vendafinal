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
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nome do gateway
            $table->string('type'); // Tipo do gateway (expay, mercado_pago, etc)
            $table->text('description')->nullable(); // Descrição do gateway
            $table->json('credentials'); // Credenciais (API key, secret, etc) - criptografado
            $table->json('settings')->nullable(); // Configurações adicionais
            $table->boolean('is_active')->default(false); // Se está ativo
            $table->boolean('is_pix_enabled')->default(true); // Se aceita PIX
            $table->boolean('is_credit_card_enabled')->default(false); // Se aceita cartão
            $table->boolean('is_boleto_enabled')->default(false); // Se aceita boleto
            $table->integer('priority')->default(0); // Prioridade de uso
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
