<?php

namespace App\Filament\Resources\InstagramProfiles\Pages;

use App\Filament\Resources\InstagramProfiles\InstagramProfileResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInstagramProfile extends EditRecord
{
    protected static string $resource = InstagramProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
