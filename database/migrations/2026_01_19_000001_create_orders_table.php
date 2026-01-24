<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('package_id')
                ->constrained('packages')
                ->restrictOnDelete();

            // Só é preenchido quando o pagamento é confirmado.
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('status', 40)->index();

            $table->string('customer_name');
            $table->string('customer_email', 190)->index();
            $table->string('customer_phone', 30)->nullable();

            $table->string('instagram_username', 60)->index();
            $table->json('instagram_profile')->nullable();

            // Snapshot para auditoria (nome/preço etc.) caso o pacote mude.
            $table->json('package_snapshot')->nullable();

            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('BRL');

            // Pix (por enquanto estático via .env)
            $table->text('pix_brcode')->nullable();
            $table->timestamp('pix_generated_at')->nullable();

            $table->timestamp('paid_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
