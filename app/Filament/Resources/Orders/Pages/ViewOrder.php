<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\Actions\CancelOrderAction;
use App\Filament\Resources\Orders\Actions\ConfirmPaymentAction;
use App\Filament\Resources\Orders\Actions\ResendCredentialsAction;
use App\Filament\Resources\Orders\Actions\ResendPixAction;
use App\Filament\Resources\Orders\OrderResource;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ConfirmPaymentAction::make(),
            CancelOrderAction::make(),
            ResendCredentialsAction::make(),
            ResendPixAction::make(),
        ];
    }
}
