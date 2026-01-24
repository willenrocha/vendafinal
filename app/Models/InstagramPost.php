<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstagramPost extends Model
{
    protected $fillable = [
        'instagram_profile_id',
        'instagram_id',
        'shortcode',
        'media_type',
        'caption',
        'like_count',
        'comment_count',
        'taken_at',
        'images',
        'metadata',
    ];

    protected $casts = [
        'taken_at' => 'datetime',
        'images' => 'array',
        'metadata' => 'array',
        'like_count' => 'integer',
        'comment_count' => 'integer',
        'media_type' => 'integer',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(InstagramProfile::class, 'instagram_profile_id');
    }

    /**
     * Obtém a URL do Instagram para este post
     */
    public function getInstagramUrlAttribute(): string
    {
        return "https://www.instagram.com/p/{$this->shortcode}/";
    }

    /**
     * Verifica se é uma foto
     */
    public function isPhoto(): bool
    {
        return $this->media_type === 1;
    }

    /**
     * Verifica se é um vídeo
     */
    public function isVideo(): bool
    {
        return $this->media_type === 2;
    }

    /**
     * Verifica se é um carousel
     */
    public function isCarousel(): bool
    {
        return $this->media_type === 8;
    }

    /**
     * Obtém a primeira imagem em base64
     */
    public function getFirstImageBase64Attribute(): ?string
    {
        return $this->images[0]['base64'] ?? null;
    }
}
