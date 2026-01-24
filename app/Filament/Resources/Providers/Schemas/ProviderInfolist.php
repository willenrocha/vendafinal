<?php

namespace App\Filament\Resources\Providers\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProviderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Provedor')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nome'),

                        TextEntry::make('is_active')
                            ->label('Ativo')
                            ->badge()
                            ->formatStateUsing(fn (bool $state): string => $state ? 'Sim' : 'Não')
                            ->color(fn (bool $state): string => $state ? 'success' : 'gray'),

                        TextEntry::make('api_url')
                            ->label('URL da API')
                            ->columnSpanFull(),
                    ]),

                Section::make('Saldo')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('balance')
                            ->label('Saldo')
                            ->formatStateUsing(function ($state, $record): string {
                                if (blank($state)) {
                                    return '—';
                                }

                                return trim($state . ' ' . ($record->currency ?? ''));
                            }),

                        TextEntry::make('currency')
                            ->label('Moeda')
                            ->badge(),

                        TextEntry::make('balance_synced_at')
                            ->label('Atualizado')
                            ->since()
                            ->sinceTooltip(),
                    ]),

                Section::make('Erros')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        TextEntry::make('last_error_at')
                            ->label('Quando')
                            ->since()
                            ->sinceTooltip(),

                        TextEntry::make('last_error')
                            ->label('Mensagem')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
