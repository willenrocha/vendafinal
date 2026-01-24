<?php

namespace App\Filament\Resources\Orders\Actions;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Notifications\CustomerAccountCreatedNotification;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification as NotificationFacade;
use Illuminate\Support\Str;

class ResendCredentialsAction
{
    public static function make(): Action
    {
        return Action::make('resendCredentials')
            ->label('Reenviar credenciais')
            ->icon('heroicon-o-key')
            ->requiresConfirmation()
            ->modalHeading('Reenviar credenciais de acesso')
            ->modalDescription('Uma nova senha temporária será gerada e enviada por e-mail ao cliente.')
            ->color('info')
            ->visible(fn (Order $record): bool => (
                ($record->status?->value ?? (string) $record->status) === OrderStatus::Paid->value
                && $record->user_id !== null
            ))
            ->action(function (Order $record): void {
                $user = $record->user;

                if (! $user) {
                    Notification::make()
                        ->title('Erro')
                        ->body('Usuário não encontrado para este pedido.')
                        ->danger()
                        ->send();

                    return;
                }

                if ((bool) ($user->is_admin ?? false)) {
                    Notification::make()
                        ->title('Erro')
                        ->body('Não é possível reenviar credenciais para um administrador.')
                        ->danger()
                        ->send();

                    return;
                }

                $temporaryPassword = Str::password(12);

                $user->forceFill([
                    'password' => Hash::make($temporaryPassword),
                ])->save();

                NotificationFacade::route('mail', (string) $record->customer_email)
                    ->notify(new CustomerAccountCreatedNotification(
                        order: $record,
                        temporaryPassword: $temporaryPassword,
                        loginUrl: (string) config('services.client.app_url', ''),
                    ));

                Notification::make()
                    ->title('Credenciais reenviadas')
                    ->body('Uma nova senha temporária foi enviada para ' . $record->customer_email)
                    ->success()
                    ->send();
            });
    }
}
