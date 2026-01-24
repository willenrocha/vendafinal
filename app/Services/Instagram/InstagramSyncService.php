<?php

declare(strict_types=1);

namespace App\Services\Instagram;

use App\Models\InstagramPost;
use App\Models\InstagramProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class InstagramSyncService
{
    public function __construct(
        private readonly HikerApiClient $hikerApi
    ) {}

    /**
     * Sincroniza o perfil e seus posts do Instagram
     *
     * @param InstagramProfile $profile
     * @param int $postsLimit Quantidade de posts para buscar (padrão: 12)
     * @return array{profile_updated: bool, posts_synced: int, errors: array<string>}
     */
    public function syncProfile(InstagramProfile $profile, int $postsLimit = 12): array
    {
        $errors = [];
        $profileUpdated = false;
        $postsSynced = 0;

        try {
            DB::beginTransaction();

            // 1. Atualizar dados do perfil
            $profileUpdated = $this->updateProfileData($profile);

            // 2. Buscar e sincronizar posts
            $postsSynced = $this->syncProfilePosts($profile, $postsLimit);

            DB::commit();

            Log::info('Instagram profile synced', [
                'profile_id' => $profile->id,
                'username' => $profile->username,
                'posts_synced' => $postsSynced,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            $errors[] = $e->getMessage();

            Log::error('Failed to sync Instagram profile', [
                'profile_id' => $profile->id,
                'username' => $profile->username,
                'error' => $e->getMessage(),
            ]);
        }

        return [
            'profile_updated' => $profileUpdated,
            'posts_synced' => $postsSynced,
            'errors' => $errors,
        ];
    }

    /**
     * Atualiza os dados do perfil do Instagram
     */
    private function updateProfileData(InstagramProfile $profile): bool
    {
        try {
            // Busca dados atualizados do perfil
            $result = $this->hikerApi->lookupByUsername($profile->username);

            if (!$result['exists']) {
                throw new \RuntimeException("Perfil {$profile->username} não encontrado");
            }

            $profileData = $result['profile'] ?? [];

            // Baixa e converte foto de perfil para base64
            $profilePicBase64 = null;
            if (!empty($profileData['profile_pic_url'])) {
                $profilePicBase64 = $this->hikerApi->downloadImageAsBase64(
                    $profileData['profile_pic_url'],
                    maxSizeKb: 500 // Limita foto de perfil a 500KB
                );
            }

            // Atualiza o perfil
            $profile->update([
                'full_name' => $profileData['full_name'] ?? null,
                'biography' => $profileData['biography'] ?? null,
                'profile_pic_base64' => $profilePicBase64,
                'follower_count' => $profileData['follower_count'] ?? null,
                'following_count' => $profileData['following_count'] ?? null,
                'media_count' => $profileData['media_count'] ?? null,
                'is_verified' => $profileData['is_verified'] ?? false,
                'is_business' => $profileData['is_business'] ?? false,
                'is_active' => true, // Marca como ativo após sincronização bem-sucedida
                'profile_data' => $profileData,
                'last_synced_at' => now(),
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to update profile data', [
                'profile_id' => $profile->id,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Sincroniza os posts do perfil
     */
    private function syncProfilePosts(InstagramProfile $profile, int $limit = 12): int
    {
        // Primeiro tenta buscar dados atualizados do perfil para obter o user_id
        $result = $this->hikerApi->lookupByUsername($profile->username);

        if (!$result['exists']) {
            throw new \RuntimeException("Perfil {$profile->username} não encontrado");
        }

        $profileData = $result['profile'] ?? [];

        // Busca o user_id do Instagram (pk ou id)
        $userId = null;

        // Tenta diferentes campos onde o ID pode estar
        if (isset($profileData['pk'])) {
            $userId = $profileData['pk'];
        } elseif (isset($profileData['id'])) {
            $userId = $profileData['id'];
        } elseif (isset($profile->profile_data['pk'])) {
            $userId = $profile->profile_data['pk'];
        } elseif (isset($profile->profile_data['id'])) {
            $userId = $profile->profile_data['id'];
        }

        if (!$userId) {
            throw new \RuntimeException("Não foi possível obter o user_id do perfil {$profile->username}");
        }

        // Busca os posts
        $postsData = $this->hikerApi->getProfilePosts((string) $userId, $limit);
        $items = $postsData['items'] ?? [];

        $syncedCount = 0;

        foreach ($items as $item) {
            try {
                $this->createOrUpdatePost($profile, $item);
                $syncedCount++;
            } catch (\Exception $e) {
                Log::warning('Failed to sync post', [
                    'profile_id' => $profile->id,
                    'post_id' => $item['id'] ?? 'unknown',
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $syncedCount;
    }

    /**
     * Cria ou atualiza um post
     */
    private function createOrUpdatePost(InstagramProfile $profile, array $item): void
    {
        $instagramId = (string) ($item['pk'] ?? $item['id']);
        $shortcode = (string) ($item['code'] ?? '');
        $mediaType = (int) ($item['media_type'] ?? 1);
        $caption = (string) ($item['caption']['text'] ?? '');
        $likeCount = (int) ($item['like_count'] ?? 0);
        $commentCount = (int) ($item['comment_count'] ?? 0);

        // A API às vezes retorna "1ltaken_at" ao invés de "taken_at"
        $takenAt = $item['taken_at'] ?? $item['1ltaken_at'] ?? null;

        if (!$takenAt) {
            Log::warning('Post sem data de publicação', [
                'profile_id' => $profile->id,
                'post_id' => $instagramId,
                'item_keys' => array_keys($item),
            ]);
            throw new \RuntimeException('Post sem data de publicação');
        }

        // Processa as imagens
        $images = $this->extractAndConvertImages($item);

        // Cria ou atualiza o post
        InstagramPost::updateOrCreate(
            [
                'instagram_profile_id' => $profile->id,
                'instagram_id' => $instagramId,
            ],
            [
                'shortcode' => $shortcode,
                'media_type' => $mediaType,
                'caption' => $caption,
                'like_count' => $likeCount,
                'comment_count' => $commentCount,
                'taken_at' => \Carbon\Carbon::createFromTimestamp((int) $takenAt),
                'images' => $images,
                'metadata' => $item,
            ]
        );
    }

    /**
     * Extrai as URLs das imagens e converte para base64
     */
    private function extractAndConvertImages(array $item): array
    {
        $images = [];

        // Para posts com carousel (múltiplas imagens)
        if (isset($item['carousel_media']) && is_array($item['carousel_media'])) {
            foreach ($item['carousel_media'] as $carouselItem) {
                $imageUrl = $this->getBestImageUrl($carouselItem);
                if ($imageUrl) {
                    $images[] = $this->downloadAndEncodeImage($imageUrl);
                }
            }
        }
        // Para posts com imagem única
        elseif (isset($item['image_versions2']['candidates'])) {
            $imageUrl = $this->getBestImageUrl($item);
            if ($imageUrl) {
                $images[] = $this->downloadAndEncodeImage($imageUrl);
            }
        }

        return $images;
    }

    /**
     * Obtém a melhor URL de imagem (maior resolução disponível)
     */
    private function getBestImageUrl(array $item): ?string
    {
        $candidates = $item['image_versions2']['candidates'] ?? [];

        if (empty($candidates)) {
            return null;
        }

        // Pega a primeira (geralmente a de maior resolução)
        return $candidates[0]['url'] ?? null;
    }

    /**
     * Baixa uma imagem e retorna os dados em base64
     */
    private function downloadAndEncodeImage(string $url): array
    {
        $base64 = $this->hikerApi->downloadImageAsBase64($url, maxSizeKb: 2048);

        return [
            'url_original' => $url,
            'base64' => $base64,
            'downloaded_at' => now()->toIso8601String(),
        ];
    }
}
