<?php

namespace App\Filament\Resources\Credits\Pages;

use App\Filament\Resources\Credits\Actions\AddCreditsAction;
use App\Filament\Resources\Credits\Actions\RemoveCreditsAction;
use App\Filament\Resources\Credits\UserCreditBalanceResource;
use Filament\Resources\Pages\ViewRecord;

class ViewUserCreditBalance extends ViewRecord
{
    protected static string $resource = UserCreditBalanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            AddCreditsAction::make(),
            RemoveCreditsAction::make(),
        ];
    }
}
