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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->boolean('is_active')->default(true);

            $table->boolean('is_featured')->default(false);
            $table->string('badge_text')->nullable();

            $table->unsignedInteger('display_min')->nullable();
            $table->unsignedInteger('display_max')->nullable();
            $table->string('display_unit')->nullable();

            $table->decimal('original_price', 10, 2)->nullable();
            $table->decimal('price', 10, 2);

            $table->string('cta_label')->default('Comprar Agora');
            $table->string('cta_href')->default('#comprar');

            $table->unsignedInteger('sort_order_mobile')->nullable();
            $table->unsignedInteger('sort_order_desktop')->nullable();

            $table->foreignId('primary_service_id')
                ->constrained('services')
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
