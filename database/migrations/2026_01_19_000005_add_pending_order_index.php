<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Índice composto para performance e lógica de "pedido pendente único"
        Schema::table('orders', function (Blueprint $table) {
            $table->index(['customer_email', 'package_id', 'instagram_username', 'status'], 'orders_pending_lookup');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('orders_pending_lookup');
        });
    }
};
