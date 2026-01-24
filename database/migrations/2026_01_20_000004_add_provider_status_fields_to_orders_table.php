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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('provider_order_status')->nullable()->after('provider_order_sent_at');
            $table->decimal('provider_charge', 10, 5)->nullable()->after('provider_order_status');
            $table->integer('provider_start_count')->nullable()->after('provider_charge');
            $table->integer('provider_remains')->nullable()->after('provider_start_count');
            $table->string('provider_currency', 10)->nullable()->after('provider_remains');
            $table->timestamp('provider_last_check_at')->nullable()->after('provider_currency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'provider_order_status',
                'provider_charge',
                'provider_start_count',
                'provider_remains',
                'provider_currency',
                'provider_last_check_at',
            ]);
        });
    }
};
