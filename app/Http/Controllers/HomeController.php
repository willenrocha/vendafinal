<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\View\View;

class HomeController
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

        return view('welcome', compact('packages'));
    }
}
