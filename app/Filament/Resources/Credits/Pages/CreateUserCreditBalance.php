<?php

namespace App\Filament\Resources\Credits\Pages;

use App\Filament\Resources\Credits\UserCreditBalanceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserCreditBalance extends CreateRecord
{
    protected static string $resource = UserCreditBalanceResource::class;
}
