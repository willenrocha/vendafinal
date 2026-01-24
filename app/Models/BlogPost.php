<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'category',
        'tags',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'is_published',
        'published_at',
        'reading_time',
        'views_count',
        'author_id',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
        'reading_time' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }

            if (empty($post->reading_time) && !empty($post->content)) {
                $post->reading_time = max(1, (int) ceil(str_word_count(strip_tags($post->content)) / 200));
            }

            if (empty($post->meta_title)) {
                $post->meta_title = $post->title;
            }

            if (empty($post->excerpt) && !empty($post->content)) {
                $post->excerpt = Str::limit(strip_tags($post->content), 200);
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('title') && empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }

            if ($post->isDirty('content') && !empty($post->content)) {
                $post->reading_time = max(1, (int) ceil(str_word_count(strip_tags($post->content)) / 200));
            }

            if (empty($post->meta_title)) {
                $post->meta_title = $post->title;
            }

            if (empty($post->excerpt) && !empty($post->content)) {
                $post->excerpt = Str::limit(strip_tags($post->content), 200);
            }
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function getFormattedPublishedAtAttribute(): string
    {
        if (!$this->published_at) {
            return '';
        }

        return $this->published_at->locale('pt_BR')->isoFormat('DD [de] MMMM[,] YYYY');
    }

    public function getReadingTimeTextAttribute(): string
    {
        return $this->reading_time ? "{$this->reading_time} min de leitura" : '';
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
