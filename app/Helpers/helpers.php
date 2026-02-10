<?php

use App\Helpers\ImageHelper;

if (!function_exists('proxy_image')) {
    /**
     * Retorna URL da imagem via proxy para evitar CORS
     *
     * @param string|null $url URL da imagem ou base64
     * @param string|null $fallback URL fallback se $url for null
     * @return string|null
     */
    function proxy_image(?string $url, ?string $fallback = null): ?string
    {
        return ImageHelper::proxy($url, $fallback);
    }
}

if (!function_exists('instagram_image')) {
    /**
     * Processa imagem de post do Instagram
     *
     * @param array|null $imageData
     * @return string|null
     */
    function instagram_image(?array $imageData): ?string
    {
        return ImageHelper::fromInstagramPost($imageData);
    }
}
