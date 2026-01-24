<?php

namespace App\Filament\Resources\ProviderOrders\Pages;

use App\Filament\Resources\ProviderOrders\ProviderOrderResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProviderOrder extends EditRecord
{
    protected static string $resource = ProviderOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
