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
}
