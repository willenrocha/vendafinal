<?php

namespace App\Filament\Resources\ProviderOrders\Actions;

use App\Jobs\UpdateProviderOrderStatusJob;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class CheckProviderStatusAction
{
    public static function make(): Action
    {
        return Action::make('checkStatus')
            ->label('Verificar Status')
            ->icon('heroicon-o-arrow-path')
            ->color('info')
            ->requiresConfirmation()
            ->action(function ($record) {
                if (! $record->provider_order_id) {
                    Notification::make()
                        ->title('Pedido não enviado')
                        ->body('Este pedido ainda não foi enviado ao provedor.')
                        ->warning()
                        ->send();

                    return;
                }

                UpdateProviderOrderStatusJob::dispatch($record->id);

                Notification::make()
                    ->title('Verificação agendada')
                    ->body('O status será atualizado em alguns segundos.')
                    ->success()
                    ->send();
            })
            ->visible(fn ($record) => $record->provider_order_id !== null);
    }
}
