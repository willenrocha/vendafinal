<?php

namespace App\Filament\Resources\Packages\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PackageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Pacote')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nome')
                            ->columnSpanFull(),

                        TextEntry::make('is_active')
                            ->label('Ativo')
                            ->badge()
                            ->formatStateUsing(fn (bool $state): string => $state ? 'Sim' : 'Não')
                            ->color(fn (bool $state): string => $state ? 'success' : 'gray'),

                        TextEntry::make('is_featured')
                            ->label('Destaque')
                            ->badge()
                            ->formatStateUsing(fn (bool $state): string => $state ? 'Sim' : 'Não')
                            ->color(fn (bool $state): string => $state ? 'warning' : 'gray'),

                        TextEntry::make('badge_text')
                            ->label('Selo')
                            ->badge(),

                        TextEntry::make('primaryService.name')
                            ->label('Serviço principal')
                            ->badge()
                            ->columnSpanFull(),

                        TextEntry::make('price')
                            ->label('Preço')
                            ->money('BRL'),

                        TextEntry::make('original_price')
                            ->label('Preço original')
                            ->money('BRL'),

                        TextEntry::make('display_unit')
                            ->label('Unidade (exibição)')
                            ->columnSpanFull(),

                        TextEntry::make('cta_label')
                            ->label('Botão')
                            ->badge(),
                    ]),
            ]);
    }
}
