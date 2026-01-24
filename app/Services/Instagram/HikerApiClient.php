<?php

declare(strict_types=1);

namespace App\Services\Instagram;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

final class HikerApiClient
{
    /**
     * @return array{
     *   exists: bool,
     *   is_private?: bool,
     *   profile?: array{
     *     username: string,
     *     full_name: string,
     *     biography: string,
     *     profile_pic_url: string,
     *     is_verified: bool,
     *     follower_count: int,
     *     following_count: int,
     *   }
     * }
     */
    public function lookupByUsername(string $username): array
    {
        $baseUrl = (string) config('services.hikerapi.base_url');
        $accessKey = (string) config('services.hikerapi.access_key');

        if ($baseUrl === '' || $accessKey === '') {
            throw new \RuntimeException('HikerApi não configurada (services.hikerapi.*).');
        }

        $url = rtrim($baseUrl, '/') . '/v2/user/by/username';

        $response = Http::timeout(15)
            ->acceptJson()
            ->withHeaders([
                'x-access-key' => $accessKey,
            ])
            ->get($url, [
                'username' => $username,
            ]);

        if ($response->status() === 404) {
            return ['exists' => false];
        }

        try {
            $response->throw();
        } catch (RequestException $e) {
            throw new \RuntimeException('Falha ao consultar a HikerApi.', 0, $e);
        }

        /** @var array{user?: array<string, mixed>} $payload */
        $payload = $response->json() ?? [];
        /** @var array<string, mixed> $user */
        $user = (array) ($payload['user'] ?? []);

        $profile = [
            'pk' => (string) ($user['pk'] ?? $user['id'] ?? ''),
            'id' => (string) ($user['id'] ?? $user['pk'] ?? ''),
            'username' => (string) ($user['username'] ?? $username),
            'full_name' => (string) ($user['full_name'] ?? ''),
            'biography' => (string) ($user['biography'] ?? ''),
            'profile_pic_url' => (string) ($user['profile_pic_url'] ?? ''),
            'is_verified' => (bool) ($user['is_verified'] ?? false),
            'follower_count' => (int) ($user['follower_count'] ?? 0),
            'following_count' => (int) ($user['following_count'] ?? 0),
            'media_count' => (int) ($user['media_count'] ?? 0),
            'is_business' => (bool) ($user['is_business_account'] ?? $user['is_business'] ?? false),
        ];

        return [
            'exists' => true,
            'is_private' => (bool) ($user['is_private'] ?? false),
            'profile' => $profile,
        ];
    }

    /**
     * Busca os posts/mídias de um perfil do Instagram
     *
     * @return array{
     *   items: array<array<string, mixed>>,
     *   user: array<string, mixed>,
     *   more_available: bool,
     *   next_max_id?: string
     * }
     */
    public function getProfilePosts(string $userId, int $limit = 12): array
    {
        $baseUrl = (string) config('services.hikerapi.base_url');
        $accessKey = (string) config('services.hikerapi.access_key');

        if ($baseUrl === '' || $accessKey === '') {
            throw new \RuntimeException('HikerApi não configurada (services.hikerapi.*).');
        }

        $url = rtrim($baseUrl, '/') . '/gql/user/medias';

        $response = Http::timeout(30)
            ->acceptJson()
            ->withHeaders([
                'x-access-key' => $accessKey,
            ])
            ->get($url, [
                'user_id' => $userId,
                'flat' => 'true',
            ]);

        try {
            $response->throw();
        } catch (RequestException $e) {
            throw new \RuntimeException('Falha ao buscar posts da HikerApi.', 0, $e);
        }

        /** @var array{items?: array<array<string, mixed>>, user?: array<string, mixed>} $payload */
        $payload = $response->json() ?? [];

        return [
            'items' => array_slice((array) ($payload['items'] ?? []), 0, $limit),
            'user' => (array) ($payload['user'] ?? []),
            'more_available' => (bool) ($payload['more_available'] ?? false),
            'next_max_id' => (string) ($payload['next_max_id'] ?? ''),
        ];
    }

    /**
     * Faz download de uma imagem e converte para base64
     */
    public function downloadImageAsBase64(string $url, int $maxSizeKb = 1024): ?string
    {
        try {
            $response = Http::timeout(15)->get($url);

            if (!$response->successful()) {
                return null;
            }

            $imageData = $response->body();
            $sizeKb = strlen($imageData) / 1024;

            // Limita o tamanho da imagem
            if ($sizeKb > $maxSizeKb) {
                return null;
            }

            // Detecta o tipo MIME da imagem
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($imageData);

            return 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
        } catch (\Exception $e) {
            \Log::warning('Falha ao baixar imagem: ' . $url, [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }
}
