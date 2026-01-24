<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->uuid('public_id')->nullable()->unique()->after('id');
        });

        // Backfill para pedidos já existentes.
        $ids = DB::table('orders')->whereNull('public_id')->pluck('id');
        foreach ($ids as $id) {
            DB::table('orders')->where('id', $id)->update([
                'public_id' => (string) Str::uuid(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropUnique(['public_id']);
            $table->dropColumn('public_id');
        });
    }
};
