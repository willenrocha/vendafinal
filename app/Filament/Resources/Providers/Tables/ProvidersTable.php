<?php

namespace App\Filament\Resources\Providers\Tables;

use App\Models\Provider;
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
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProvidersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('api_url')
                    ->label('URL')
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->limit(40),

                ToggleColumn::make('is_active')
                    ->label('Ativo'),

                TextColumn::make('balance')
                    ->label('Saldo')
                    ->numeric(decimalPlaces: 8)
                    ->sortable(),

                TextColumn::make('currency')
                    ->label('Moeda')
                    ->badge()
                    ->sortable(),

                TextColumn::make('balance_synced_at')
                    ->label('Atualizado')
                    ->since()
                    ->sinceTooltip()
                    ->sortable(),

                TextColumn::make('last_error')
                    ->label('Último erro')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Ativo'),
            ])
            ->recordActions([
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
