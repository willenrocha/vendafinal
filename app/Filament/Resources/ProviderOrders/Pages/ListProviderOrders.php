<?php

namespace App\Filament\Resources\ProviderOrders\Pages;

use App\Filament\Resources\ProviderOrders\ProviderOrderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProviderOrders extends ListRecords
{
    protected static string $resource = ProviderOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
