<?php

namespace App\Filament\Resources\Providers\Schemas;

use App\Models\Provider;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProviderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Provedor')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Toggle::make('is_active')
                            ->label('Ativo')
                            ->default(true),

                        TextInput::make('api_url')
                            ->label('URL da API')
                            ->helperText('Endpoint do PerfectPanel (ex: https://painel.exemplo.com/api/v2)')
                            ->required()
                            ->url()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('api_key')
                            ->label('API Key')
                            ->required()
                            ->password()
                            ->revealable()
                            ->columnSpanFull(),
                    ]),

                Section::make('Saldo')
                    ->columns(3)
                    ->collapsed(fn (string $operation): bool => $operation === 'create')
                    ->schema([
                        Placeholder::make('balance_display')
                            ->label('Saldo')
                            ->content(function (?Provider $record): string {
                                if (! $record?->balance) {
                                    return '—';
                                }

                                return trim($record->balance . ' ' . ($record->currency ?? ''));
                            }),

                        Placeholder::make('currency')
                            ->label('Moeda')
                            ->content(fn (?Provider $record): string => $record?->currency ?: '—'),

                        Placeholder::make('balance_synced_at')
                            ->label('Última atualização')
                            ->content(fn (?Provider $record): string => $record?->balance_synced_at?->toDateTimeString() ?: '—'),

                        Placeholder::make('last_error')
                            ->label('Último erro')
                            ->content(fn (?Provider $record): string => $record?->last_error ?: '—')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
