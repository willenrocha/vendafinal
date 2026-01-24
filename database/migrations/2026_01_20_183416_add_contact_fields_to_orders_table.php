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
            $table->timestamp('contacted_at')->nullable()->after('email_sent_at');
            $table->text('contact_notes')->nullable()->after('contacted_at');
            $table->string('contacted_by')->nullable()->after('contact_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['contacted_at', 'contact_notes', 'contacted_by']);
        });
    }
};
