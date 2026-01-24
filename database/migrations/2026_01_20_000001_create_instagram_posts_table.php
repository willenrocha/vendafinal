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
        Schema::create('instagram_posts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('instagram_profile_id')
                ->constrained('instagram_profiles')
                ->cascadeOnDelete();

            // IDs do Instagram
            $table->string('instagram_id')->index(); // O "pk" da API
            $table->string('shortcode')->index(); // O "code" da API

            // Tipo de mídia: 1 = foto, 2 = vídeo, 8 = carousel
            $table->tinyInteger('media_type');

            // Conteúdo
            $table->text('caption')->nullable();

            // Métricas
            $table->bigInteger('like_count')->default(0);
            $table->integer('comment_count')->default(0);

            // Data de publicação no Instagram
            $table->timestamp('taken_at');

            // Imagens em base64 (array de objetos com url_original e base64)
            $table->json('images');

            // Dados completos da API para referência
            $table->json('metadata')->nullable();

            $table->timestamps();

            // Índices
            $table->unique(['instagram_profile_id', 'instagram_id']);
            $table->index('taken_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instagram_posts');
    }
};
