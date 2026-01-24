<?php

namespace App\Filament\Resources\Credits\Tables;

use App\Filament\Resources\Credits\Actions\AddCreditsAction;
use App\Filament\Resources\Credits\Actions\RemoveCreditsAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserCreditBalancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.email')
                    ->label('Usuário')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('likes')
                    ->label('Curtidas')
                    ->sortable(),

                TextColumn::make('views')
                    ->label('Visualizações')
                    ->sortable(),

                TextColumn::make('comments')
                    ->label('Comentários')
                    ->sortable(),
            ])
            ->recordActions([
                ViewAction::make(),
                AddCreditsAction::make(),
                RemoveCreditsAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
