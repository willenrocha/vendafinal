<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\View\View;

class PackagesController
{
    public function __invoke(): View
    {
        $packages = Package::query()
            ->where('is_active', true)
            ->with([
                'bonusItems' => fn ($query) => $query
                    ->where('is_active', true)
                    ->orderBy('id'),
            ])
            ->orderBy('id')
            ->get();

        // Agrupar pacotes por rede social (ou service_id se disponível)
        // Por enquanto, vamos agrupar por uma categoria genérica
        $packagesByCategory = $packages->groupBy(function ($package) {
            // Se você tiver um campo 'category' ou 'service_id', use-o aqui
            // Por enquanto, vamos usar o nome do pacote para inferir a categoria
            $name = strtolower($package->name);

            if (str_contains($name, 'instagram')) {
                return 'Instagram';
            } elseif (str_contains($name, 'tiktok')) {
                return 'TikTok';
            } elseif (str_contains($name, 'youtube')) {
                return 'YouTube';
            } elseif (str_contains($name, 'facebook')) {
                return 'Facebook';
            } elseif (str_contains($name, 'twitter') || str_contains($name, 'x')) {
                return 'Twitter/X';
            }

            return 'Instagram'; // Default para Instagram
        });

        return view('packages', compact('packages', 'packagesByCategory'));
    }
}
