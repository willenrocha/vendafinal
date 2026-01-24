<?php

namespace App\Filament\Resources\Credits\Pages;

use App\Filament\Resources\Credits\UserCreditBalanceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUserCreditBalance extends EditRecord
{
    protected static string $resource = UserCreditBalanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
