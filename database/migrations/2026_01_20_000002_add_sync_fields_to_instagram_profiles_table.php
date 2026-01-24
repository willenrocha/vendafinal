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
        Schema::table('instagram_profiles', function (Blueprint $table) {
            // Campos adicionais para informações atualizadas do perfil
            $table->string('full_name')->nullable()->after('username');
            $table->text('biography')->nullable()->after('full_name');
            $table->string('profile_pic_base64', 10000)->nullable()->after('biography');
            $table->bigInteger('follower_count')->nullable()->after('profile_pic_base64');
            $table->bigInteger('following_count')->nullable()->after('follower_count');
            $table->integer('media_count')->nullable()->after('following_count');
            $table->boolean('is_business')->default(false)->after('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('instagram_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'full_name',
                'biography',
                'profile_pic_base64',
                'follower_count',
                'following_count',
                'media_count',
                'is_business',
            ]);
        });
    }
};
