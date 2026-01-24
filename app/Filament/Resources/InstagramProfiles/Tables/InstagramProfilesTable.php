<?php

namespace App\Filament\Resources\InstagramProfiles\Tables;

use App\Filament\Resources\InstagramProfiles\Actions\SyncProfileDataAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class InstagramProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('username')
                    ->label('Username')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->prefix('@')
                    ->weight('bold'),

                TextColumn::make('full_name')
                    ->label('Nome Completo')
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),

                TextColumn::make('user.email')
                    ->label('Proprietário')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('follower_count')
                    ->label('Seguidores')
                    ->sortable()
                    ->numeric()
                    ->placeholder('—')
                    ->formatStateUsing(fn ($state) => $state ? number_format((int) $state, 0, ',', '.') : '—'),

                TextColumn::make('media_count')
                    ->label('Posts')
                    ->sortable()
                    ->numeric()
                    ->placeholder('—')
                    ->formatStateUsing(fn ($state) => $state ? number_format((int) $state, 0, ',', '.') : '—'),

                TextColumn::make('posts_count')
                    ->label('Posts Salvos')
                    ->counts('posts')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                IconColumn::make('is_verified')
                    ->label('Verificado')
                    ->boolean()
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Ativo')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('last_synced_at')
                    ->label('Última Sincronização')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Nunca')
                    ->since()
                    ->tooltip(fn ($state) => $state?->format('d/m/Y H:i:s')),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('user_id')
                    ->label('Usuário')
                    ->relationship('user', 'email')
                    ->searchable()
                    ->preload(),

                TernaryFilter::make('is_verified')
                    ->label('Verificado')
                    ->placeholder('Todos')
                    ->trueLabel('Verificados')
                    ->falseLabel('Não verificados'),

                TernaryFilter::make('is_active')
                    ->label('Ativo')
                    ->placeholder('Todos')
                    ->trueLabel('Ativos')
                    ->falseLabel('Inativos'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                SyncProfileDataAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
