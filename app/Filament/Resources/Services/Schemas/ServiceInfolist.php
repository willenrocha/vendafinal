<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Serviço')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nome (nosso)'),

                        TextEntry::make('is_active')
                            ->label('Ativo')
                            ->badge()
                            ->formatStateUsing(fn (bool $state): string => $state ? 'Sim' : 'Não')
                            ->color(fn (bool $state): string => $state ? 'success' : 'gray'),

                        TextEntry::make('social_network')
                            ->label('Rede social')
                            ->badge(),

                        TextEntry::make('provider.name')
                            ->label('Provedor')
                            ->badge(),

                        TextEntry::make('provider_service_id')
                            ->label('ID no Provedor')
                            ->badge(),
                    ]),

                Section::make('Dados do Provedor')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('provider_name')
                            ->label('Nome')
                            ->columnSpanFull(),

                        TextEntry::make('provider_category')
                            ->label('Categoria'),

                        TextEntry::make('provider_type')
                            ->label('Tipo'),

                        TextEntry::make('provider_rate')
                            ->label('Rate'),

                        TextEntry::make('provider_min')
                            ->label('Min'),

                        TextEntry::make('provider_max')
                            ->label('Max'),

                        TextEntry::make('provider_refill')
                            ->label('Refill')
                            ->badge()
                            ->formatStateUsing(fn (bool $state): string => $state ? 'Sim' : 'Não'),

                        TextEntry::make('provider_cancel')
                            ->label('Cancel')
                            ->badge()
                            ->formatStateUsing(fn (bool $state): string => $state ? 'Sim' : 'Não'),

                        TextEntry::make('provider_synced_at')
                            ->label('Atualizado')
                            ->since()
                            ->sinceTooltip(),
                    ]),

                Section::make('Erros')
                    ->collapsed()
                    ->schema([
                        TextEntry::make('last_error_at')
                            ->label('Quando')
                            ->since()
                            ->sinceTooltip(),

                        TextEntry::make('last_error')
                            ->label('Mensagem'),
                    ]),
            ]);
    }
}
