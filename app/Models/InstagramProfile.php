<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstagramProfile extends Model
{
    protected $fillable = [
        'user_id',
        'username',
        'full_name',
        'biography',
        'profile_pic_url',
        'profile_pic_base64',
        'follower_count',
        'following_count',
        'media_count',
        'is_business',
        'profile_data',
        'is_verified',
        'is_active',
        'last_synced_at',
    ];

    protected function casts(): array
    {
        return [
            'profile_data' => 'array',
            'is_verified' => 'boolean',
            'is_business' => 'boolean',
            'is_active' => 'boolean',
            'last_synced_at' => 'datetime',
            'follower_count' => 'integer',
            'following_count' => 'integer',
            'media_count' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(InstagramPost::class);
    }

    /**
     * Retorna posts recentes do perfil.
     */
    public function getRecentPosts(int $limit = 9)
    {
        // Buscar dados sem o campo images (que é muito pesado)
        $posts = \DB::table('instagram_posts')
            ->where('instagram_profile_id', $this->id)
            ->select('id', 'shortcode', 'like_count', 'comment_count')
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get();

        return $posts->map(function ($post) {
            // Buscar apenas o campo images para este post específico
            $images = \DB::table('instagram_posts')
                ->where('id', $post->id)
                ->value('images');

            $imagesArray = json_decode($images, true);
            $imageData = is_array($imagesArray) && count($imagesArray) > 0
                ? $imagesArray[0]
                : null;

            $imageUrl = instagram_image($imageData);

            return [
                'id' => $post->id,
                'shortcode' => $post->shortcode,
                'image' => $imageUrl,
                'like_count' => number_format((int) $post->like_count, 0, ',', '.'),
                'comment_count' => number_format((int) $post->comment_count, 0, ',', '.'),
                'instagram_url' => 'https://www.instagram.com/p/' . $post->shortcode . '/',
            ];
        })
        ->values()
        ->toArray();
    }

    /**
     * Conta total de posts do perfil.
     */
    public function getPostsCount(): int
    {
        return $this->posts()->count();
    }

    /**
     * Busca ou cria perfil do Instagram para um usuário.
     */
    public static function findOrCreateForUser(User $user, string $username, ?array $profileData = null): self
    {
        return static::query()->firstOrCreate(
            ['username' => $username],
            [
                'user_id' => $user->id,
                'profile_data' => $profileData,
                'is_verified' => false,
                'is_active' => true,
            ]
        );
    }

    /**
     * Atualiza dados do perfil vindos da API Hiker.
     */
    public function updateProfileData(array $data): void
    {
        $this->forceFill([
            'profile_data' => $data,
            'last_synced_at' => now(),
        ])->save();
    }

    /**
     * Retorna número de seguidores do profile_data.
     */
    public function getFollowersCount(): ?int
    {
        return $this->profile_data['followers'] ?? null;
    }

    /**
     * Retorna URL da foto de perfil.
     */
    public function getProfilePicUrl(): ?string
    {
        return $this->profile_data['profile_pic_url'] ?? null;
    }

    /**
     * Retorna URL da foto de perfil via proxy (ou base64 se tiver)
     */
    public function getProfilePicProxied(): ?string
    {
        if ($this->profile_pic_base64) {
            return $this->profile_pic_base64;
        }

        if ($this->profile_pic_url) {
            return proxy_image($this->profile_pic_url);
        }

        return null;
    }
}
