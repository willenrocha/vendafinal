<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ImageProxyController extends Controller
{
    /**
     * Proxy de imagem para evitar CORS
     * Busca imagens externas e retorna para o frontend
     */
    public function proxyImage(Request $request)
    {
        $url = $request->query('url');

        if (empty($url)) {
            return response('URL not provided', 400);
        }

        // Cache usando arquivos ao invés de database (imagens são binárias)
        $cacheKey = 'proxy_image_' . md5($url);
        $cachePath = storage_path('app/cache/proxy_images/' . md5($url));

        // Verifica se existe cache válido
        if (file_exists($cachePath) && (time() - filemtime($cachePath)) < 86400) {
            $imageData = json_decode(file_get_contents($cachePath), true);
            return response(base64_decode($imageData['content']))
                ->header('Content-Type', $imageData['content_type'])
                ->header('Cache-Control', 'public, max-age=86400');
        }

        // Busca a imagem
        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'Referer' => 'https://www.instagram.com/',
                ])
                ->get($url);

            if (!$response->successful()) {
                return response('Image not found', 404);
            }

            // Salva no cache como base64 para evitar problemas com encoding
            $imageData = [
                'content' => base64_encode($response->body()),
                'content_type' => $response->header('Content-Type') ?? 'image/jpeg',
            ];

            // Garante que o diretório existe
            $dir = dirname($cachePath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            file_put_contents($cachePath, json_encode($imageData));

            return response($response->body())
                ->header('Content-Type', $imageData['content_type'])
                ->header('Cache-Control', 'public, max-age=86400');

        } catch (\Exception $e) {
            \Log::warning('Erro ao buscar imagem via proxy', [
                'url' => $url,
                'error' => $e->getMessage()
            ]);
            return response('Error fetching image', 500);
        }
    }
}
