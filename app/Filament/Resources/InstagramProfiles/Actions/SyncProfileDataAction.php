<?php

namespace App\Filament\Resources\InstagramProfiles\Actions;

use App\Jobs\SyncInstagramProfileJob;
use App\Models\InstagramProfile;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class SyncProfileDataAction
{
    public static function make(): Action
    {
        return Action::make('syncProfileData')
            ->label('Sincronizar dados')
            ->icon('heroicon-o-arrow-path')
            ->color('info')
            ->requiresConfirmation()
            ->modalHeading('Sincronizar dados do perfil')
            ->modalDescription('Buscar dados atualizados da API Hiker para este perfil e suas últimas 12 publicações.')
            ->action(function (InstagramProfile $record): void {
                // Dispara job em background para sincronizar perfil e posts
                SyncInstagramProfileJob::dispatch($record->id, 12);

                Notification::make()
                    ->title('Sincronização iniciada')
                    ->body('O perfil será atualizado em alguns segundos. A página será recarregada automaticamente.')
                    ->success()
                    ->send();
            });
    }
}
