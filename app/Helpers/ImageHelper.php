<?php

declare(strict_types=1);

namespace App\Helpers;

class ImageHelper
{
    /**
     * Converte uma URL de imagem ou base64 para usar o proxy
     *
     * @param string|null $imageData Pode ser URL, base64 completo, ou null
     * @param string|null $fallbackUrl URL alternativa se $imageData for null
     * @return string|null URL do proxy ou base64
     */
    public static function proxy(?string $imageData, ?string $fallbackUrl = null): ?string
    {
        $url = $imageData ?? $fallbackUrl;

        if (empty($url)) {
            return null;
        }

        // Se já é base64, retorna como está
        if (str_starts_with($url, 'data:image')) {
            return $url;
        }

        // Se é URL http/https, usa o proxy
        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return '/proxy-image?url=' . urlencode($url);
        }

        return $url;
    }

    /**
     * Processa dados de imagem de posts do Instagram
     * Retorna URL via proxy ou base64
     *
     * @param array|null $imageData Array com 'base64' e/ou 'url_original'
     * @return string|null
     */
    public static function fromInstagramPost(?array $imageData): ?string
    {
        if (empty($imageData)) {
            return null;
        }

        // Prioridade: URL original via proxy > base64
        if (!empty($imageData['url_original'])) {
            return self::proxy($imageData['url_original']);
        }

        if (!empty($imageData['base64'])) {
            return 'data:image/jpeg;base64,' . $imageData['base64'];
        }

        return null;
    }
}
