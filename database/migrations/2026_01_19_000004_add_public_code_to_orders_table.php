<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('public_code', 16)->nullable()->unique()->after('public_id');
        });

        // Backfill leve para pedidos existentes (código curto, humano).
        // Obs: a geração definitiva/sem colisão fica no Model (booted).
        $orders = DB::table('orders')->select('id')->whereNull('public_code')->get();
        foreach ($orders as $order) {
            DB::table('orders')->where('id', $order->id)->update([
                'public_code' => 'P' . strtoupper(bin2hex(random_bytes(4))),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropUnique(['public_code']);
            $table->dropColumn('public_code');
        });
    }
};
