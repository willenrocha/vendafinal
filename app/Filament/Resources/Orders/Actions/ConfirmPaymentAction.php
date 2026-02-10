<?php

namespace App\Filament\Resources\Orders\Actions;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Services\Orders\ConfirmPaymentService;
use Filament\Actions\Action;

class ConfirmPaymentAction
{
    public static function make(): Action
    {
        return Action::make('confirmPayment')
            ->label('Confirmar pagamento')
            ->icon('heroicon-o-check-circle')
            ->requiresConfirmation()
            ->color('success')
            ->visible(fn (Order $record): bool => (
                ($record->status?->value ?? (string) $record->status) === OrderStatus::AwaitingPayment->value
            ))
            ->action(function (Order $record): void {
                app(ConfirmPaymentService::class)->handle($record);
            });
    }
}
