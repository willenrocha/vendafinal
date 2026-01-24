<?php

namespace App\Filament\Resources\Orders\Actions;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Notifications\OrderStatusChangedNotification;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Notification;

class CancelOrderAction
{
    public static function make(): Action
    {
        return Action::make('cancelOrder')
            ->label('Cancelar')
            ->icon('heroicon-o-x-circle')
            ->requiresConfirmation()
            ->color('danger')
            ->visible(fn (Order $record): bool => (
                ($record->status?->value ?? (string) $record->status) !== OrderStatus::Paid->value
            ))
            ->action(function (Order $record): void {
                $previous = $record->status;

                $record->forceFill([
                    'status' => OrderStatus::Cancelled,
                    'cancelled_at' => now(),
                ])->save();

                Notification::route('mail', (string) $record->customer_email)
                    ->notify(new OrderStatusChangedNotification($record, $previous));
            });
    }
}
