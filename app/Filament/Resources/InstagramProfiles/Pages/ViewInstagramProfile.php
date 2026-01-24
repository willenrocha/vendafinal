<?php

namespace App\Filament\Resources\InstagramProfiles\Pages;

use App\Filament\Resources\InstagramProfiles\Actions\SyncProfileDataAction;
use App\Filament\Resources\InstagramProfiles\InstagramProfileResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewInstagramProfile extends ViewRecord
{
    protected static string $resource = InstagramProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            SyncProfileDataAction::make(),
            EditAction::make(),
        ];
    }
}
