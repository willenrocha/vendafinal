<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Instagram\HikerApiClient;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class InstagramProfileLookupController
{
    public function __invoke(Request $request, HikerApiClient $client): JsonResponse
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:31', 'regex:/^@?[A-Za-z0-9._]+$/'],
        ], [
            'username.regex' => 'Use apenas letras, números, ponto e underscore (com ou sem @).',
        ]);

        $username = ltrim(trim((string) $data['username']), '@');

        try {
            $result = Cache::remember(
                'hikerapi:username:' . strtolower($username),
                now()->addMinutes(10),
                fn () => $client->lookupByUsername($username),
            );

            if (! ($result['exists'] ?? false)) {
                return response()->json([
                    'ok' => true,
                    'exists' => false,
                ], 200);
            }

            $preview = [
                'is_private' => (bool) ($result['is_private'] ?? false),
                'profile' => (array) ($result['profile'] ?? []),
            ];

            $picUrl = (string) data_get($preview, 'profile.profile_pic_url', '');
            if ($picUrl !== '') {
                $dataUrl = Cache::remember(
                    'ig:pic:dataurl:' . md5($picUrl),
                    now()->addMinutes(30),
                    fn () => $this->downloadImageAsDataUrl($picUrl),
                );

                if (is_string($dataUrl) && $dataUrl !== '') {
                    $preview['profile']['profile_pic_data_url'] = $dataUrl;
                }
            }

            $request->session()->put('ig.preview.username', $username);
            $request->session()->put('ig.preview.data', $preview);

            return response()->json([
                'ok' => true,
                'exists' => true,
                'is_private' => $preview['is_private'],
                'profile' => $preview['profile'],
            ], 200);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'ok' => false,
                'code' => 'lookup_failed',
                'message' => 'Não foi possível validar o Instagram agora. Tente novamente em instantes.',
            ], 503);
        }
    }

    private function downloadImageAsDataUrl(string $url): ?string
    {
        $parts = parse_url($url);
        if (!is_array($parts)) {
            return null;
        }

        $scheme = (string) ($parts['scheme'] ?? '');
        $host = (string) ($parts['host'] ?? '');

        if ($scheme !== 'https' || $host === '') {
            return null;
        }

        $allowedHosts = [
            'cdninstagram.com',
            'fbcdn.net',
            'instagram.com',
        ];

        $allowed = false;
        foreach ($allowedHosts as $suffix) {
            if ($host === $suffix || str_ends_with($host, '.' . $suffix)) {
                $allowed = true;
                break;
            }
        }

        if (! $allowed) {
            return null;
        }

        try {
            $response = Http::timeout(12)
                ->withHeaders([
                    'Accept' => 'image/*',
                ])
                ->get($url);

            $response->throw();

            $contentType = (string) ($response->header('Content-Type') ?? '');
            $mime = str_contains($contentType, ';') ? trim(explode(';', $contentType, 2)[0]) : trim($contentType);
            if ($mime === '') {
                $mime = 'image/jpeg';
            }

            $bytes = (string) $response->body();
            if ($bytes === '') {
                return null;
            }

            // Limite de segurança para evitar estourar payload/cache.
            if (strlen($bytes) > 1024 * 1024) {
                return null;
            }

            return 'data:' . $mime . ';base64,' . base64_encode($bytes);
        } catch (RequestException) {
            return null;
        } catch (\Throwable) {
            return null;
        }
    }
}
