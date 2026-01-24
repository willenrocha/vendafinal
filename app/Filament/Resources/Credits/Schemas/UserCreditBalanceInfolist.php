<?php

namespace App\Filament\Resources\Credits\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserCreditBalanceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Créditos')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('user.email')
                            ->label('Usuário')
                            ->columnSpanFull(),

                        TextEntry::make('likes')
                            ->label('Curtidas'),

                        TextEntry::make('views')
                            ->label('Visualizações'),

                        TextEntry::make('comments')
                            ->label('Comentários'),
                    ]),
            ]);
    }
}
