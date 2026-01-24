<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('services')) {
            return;
        }

        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE `services` MODIFY `provider_name` VARCHAR(255) NULL');
            return;
        }

        if ($driver === 'sqlite') {
            // SQLite requires table rebuild to alter columns; keep as-is for now.
            return;
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('services')) {
            return;
        }

        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE `services` MODIFY `provider_name` VARCHAR(255) NOT NULL");
            return;
        }

        if ($driver === 'sqlite') {
            return;
        }
    }
};
