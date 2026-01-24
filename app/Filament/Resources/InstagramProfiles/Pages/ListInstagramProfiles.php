<?php

namespace App\Filament\Resources\InstagramProfiles\Pages;

use App\Filament\Resources\InstagramProfiles\InstagramProfileResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInstagramProfiles extends ListRecords
{
    protected static string $resource = InstagramProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
