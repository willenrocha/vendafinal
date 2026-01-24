<?php

namespace App\Filament\Resources\Services\Tables;

use App\Models\Service;
use App\Services\Providers\ProviderService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('provider.name')
                    ->label('Provedor')
                    ->badge()
                    ->sortable(),

                TextColumn::make('provider_service_id')
                    ->label('ID')
                    ->badge()
                    ->sortable(),

                TextColumn::make('social_network')
                    ->label('Rede')
                    ->badge()
                    ->sortable(),

                ToggleColumn::make('is_active')
                    ->label('Ativo'),

                TextColumn::make('provider_rate')
                    ->label('Rate')
                    ->numeric(decimalPlaces: 8)
                    ->sortable(),

                TextColumn::make('provider_min')
                    ->label('Min')
                    ->sortable(),

                TextColumn::make('provider_max')
                    ->label('Max')
                    ->sortable(),

                TextColumn::make('provider_synced_at')
                    ->label('Sync')
                    ->since()
                    ->sinceTooltip()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('provider')
                    ->relationship('provider', 'name')
                    ->label('Provedor')
                    ->searchable()
                    ->preload(),

                TernaryFilter::make('is_active')
                    ->label('Ativo'),
            ])
            ->recordActions([
                Action::make('sync')
                    ->label('Sincronizar')
                    ->icon(Heroicon::ArrowPath)
                    ->action(function (Service $record): void {
                        try {
                            app(ProviderService::class)->syncService($record);

                            Notification::make()
                                ->success()
                                ->title('Serviço sincronizado')
                                ->send();
                        } catch (\Throwable $e) {
                            Notification::make()
                                ->danger()
                                ->title('Falha ao sincronizar')
                                ->body($e->getMessage())
                                ->send();
                        }
                    }),
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
