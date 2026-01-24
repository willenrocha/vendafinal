<?php

namespace App\Filament\Resources\Packages\Schemas;

use App\Models\Service;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Pacote')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('Ativo')
                            ->default(true),

                        Toggle::make('is_featured')
                            ->label('Destaque (Mais vendido)')
                            ->default(false),

                        TextInput::make('badge_text')
                            ->label('Texto do selo')
                            ->placeholder('Mais Vendido')
                            ->maxLength(50)
                            ->columnSpanFull(),

                        Select::make('primary_service_id')
                            ->label('Serviço principal (entrega imediata)')
                            ->relationship('primaryService', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull(),

                        TextInput::make('display_min')
                            ->label('Min (exibição)')
                            ->numeric()
                            ->minValue(0),

                        TextInput::make('display_max')
                            ->label('Max (exibição)')
                            ->numeric()
                            ->minValue(0),

                        TextInput::make('display_unit')
                            ->label('Unidade (exibição)')
                            ->placeholder('seguidores Instagram')
                            ->maxLength(100)
                            ->columnSpanFull(),

                        TextInput::make('original_price')
                            ->label('Preço original (riscado)')
                            ->numeric()
                            ->prefix('R$'),

                        TextInput::make('price')
                            ->label('Preço')
                            ->required()
                            ->numeric()
                            ->prefix('R$'),

                        TextInput::make('cta_label')
                            ->label('Texto do botão')
                            ->default('Comprar Agora')
                            ->maxLength(50),

                        TextInput::make('cta_href')
                            ->label('Link do botão')
                            ->default('#comprar')
                            ->maxLength(255),

                        TextInput::make('sort_order_mobile')
                            ->label('Ordem (mobile)')
                            ->numeric()
                            ->minValue(0),

                        TextInput::make('sort_order_desktop')
                            ->label('Ordem (desktop)')
                            ->numeric()
                            ->minValue(0),
                    ]),

                Section::make('Bônus (créditos para o cliente)')
                    ->schema([
                        Repeater::make('bonusItems')
                            ->label('Itens bônus')
                            ->relationship('bonusItems')
                            ->defaultItems(0)
                            ->columns(2)
                            ->schema([
                                Select::make('credit_type')
                                    ->label('Tipo de crédito')
                                    ->options([
                                        'likes' => 'Curtidas',
                                        'views' => 'Visualizações',
                                        'comments' => 'Comentários',
                                    ])
                                    ->required(),

                                TextInput::make('amount')
                                    ->label('Quantidade')
                                    ->numeric()
                                    ->minValue(1)
                                    ->required(),

                                Select::make('service_id')
                                    ->label('Serviço para resgate (opcional)')
                                    ->options(fn (): array => Service::query()->orderBy('name')->pluck('name', 'id')->all())
                                    ->searchable()
                                    ->preload()
                                    ->columnSpanFull(),

                                TextInput::make('label')
                                    ->label('Título (exibição)')
                                    ->placeholder('250 Curtidas')
                                    ->maxLength(100),

                                TextInput::make('subtitle')
                                    ->label('Subtítulo (exibição)')
                                    ->placeholder('Bônus incluído')
                                    ->maxLength(100),

                                Toggle::make('is_active')
                                    ->label('Ativo')
                                    ->default(true)
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
