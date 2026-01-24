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
            $table->foreignId('instagram_profile_id')
                ->nullable()
                ->after('user_id')
                ->constrained('instagram_profiles')
                ->nullOnDelete();

            // Mantemos instagram_username temporariamente para dados legados
            // Será removido em migration futura após migração completa
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['instagram_profile_id']);
            $table->dropColumn('instagram_profile_id');
        });
    }
};
