<?php

namespace App\Filament\Resources\Credits\Pages;

use App\Filament\Resources\Credits\UserCreditBalanceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserCreditBalances extends ListRecords
{
    protected static string $resource = UserCreditBalanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
