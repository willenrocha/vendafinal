<?php

namespace App\Filament\Resources\Providers\Pages;

use App\Filament\Resources\Providers\ProviderResource;
use App\Models\Provider;
use App\Services\Providers\ProviderService;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Resources\Pages\ViewRecord;

class ViewProvider extends ViewRecord
{
    protected static string $resource = ProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('syncBalance')
                ->label('Atualizar saldo')
                ->icon(Heroicon::ArrowPath)
                ->disabled(fn (Provider $record): bool => ! $record->is_active)
                ->action(function (Provider $record): void {
                    try {
                        app(ProviderService::class)->updateBalance($record);

                        Notification::make()
                            ->success()
                            ->title('Saldo atualizado')
                            ->send();
                    } catch (\Throwable $e) {
                        Notification::make()
                            ->danger()
                            ->title('Falha ao atualizar saldo')
                            ->body($e->getMessage())
                            ->send();
                    }
                }),
            EditAction::make(),
        ];
    }
}
