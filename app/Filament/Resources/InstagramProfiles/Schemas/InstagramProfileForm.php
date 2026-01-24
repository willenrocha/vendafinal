<?php

namespace App\Filament\Resources\InstagramProfiles\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InstagramProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informações do perfil')
                    ->columns(2)
                    ->schema([
                        Select::make('user_id')
                            ->label('Usuário')
                            ->relationship('user', 'email')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull(),

                        TextInput::make('username')
                            ->label('Username Instagram')
                            ->required()
                            ->prefix('@')
                            ->maxLength(30)
                            ->unique(ignoreRecord: true)
                            ->helperText('Username sem o @'),

                        Checkbox::make('is_verified')
                            ->label('Perfil verificado')
                            ->default(false),

                        Checkbox::make('is_active')
                            ->label('Perfil ativo')
                            ->default(true),
                    ]),

                Section::make('Dados do perfil (API Hiker)')
                    ->description('Dados sincronizados da API. Deixe vazio se não tiver.')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        KeyValue::make('profile_data')
                            ->label('Dados JSON')
                            ->keyLabel('Chave')
                            ->valueLabel('Valor')
                            ->helperText('followers, following, biography, profile_pic_url, etc.'),
                    ]),
            ]);
    }
}
