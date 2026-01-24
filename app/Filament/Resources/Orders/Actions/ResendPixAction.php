<?php

namespace App\Filament\Resources\Orders\Actions;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Notifications\OrderAwaitingPaymentNotification;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Notification as NotificationFacade;

class ResendPixAction
{
    public static function make(): Action
    {
        return Action::make('resendPix')
            ->label('Reenviar Pix')
            ->icon('heroicon-o-qr-code')
            ->requiresConfirmation()
            ->modalHeading('Reenviar informações de pagamento')
            ->modalDescription('O e-mail com o código Pix será reenviado ao cliente.')
            ->color('warning')
            ->visible(fn (Order $record): bool => (
                ($record->status?->value ?? (string) $record->status) === OrderStatus::AwaitingPayment->value
                && $record->pix_brcode !== null
            ))
            ->action(function (Order $record): void {
                if (! $record->pix_brcode) {
                    Notification::make()
                        ->title('Erro')
                        ->body('Código Pix não encontrado para este pedido.')
                        ->danger()
                        ->send();

                    return;
                }

                NotificationFacade::route('mail', (string) $record->customer_email)
                    ->notify(new OrderAwaitingPaymentNotification($record));

                Notification::make()
                    ->title('Pix reenviado')
                    ->body('E-mail com código Pix enviado para ' . $record->customer_email)
                    ->success()
                    ->send();
            });
    }
}
