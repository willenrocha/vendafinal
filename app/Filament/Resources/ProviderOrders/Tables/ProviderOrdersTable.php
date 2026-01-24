<?php

namespace App\Filament\Resources\ProviderOrders\Tables;

use App\Enums\ProviderOrderStatus;
use App\Filament\Resources\ProviderOrders\Actions\CheckProviderStatusAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProviderOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('public_code')
                    ->label('Código')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->badge()
                    ->color('gray'),

                TextColumn::make('user.name')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('order.public_code')
                    ->label('Order')
                    ->searchable()
                    ->badge()
                    ->color('info')
                    ->url(fn ($record) => $record->order ? route('filament.admin.resources.orders.view', $record->order) : null)
                    ->placeholder('Créditos'),

                TextColumn::make('package.name')
                    ->label('Pacote')
                    ->badge()
                    ->color('success')
                    ->placeholder('—'),

                TextColumn::make('service.name')
                    ->label('Serviço')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('instagramProfile.username')
                    ->label('Instagram')
                    ->formatStateUsing(fn ($state) => '@'.$state)
                    ->searchable(),

                TextColumn::make('quantity')
                    ->label('Qtd')
                    ->numeric()
                    ->sortable()
                    ->badge(),

                TextColumn::make('provider_order_id')
                    ->label('ID API')
                    ->searchable()
                    ->copyable()
                    ->badge()
                    ->color('warning')
                    ->placeholder('—'),

                TextColumn::make('provider_order_status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(function ($state): string {
                        if ($state instanceof ProviderOrderStatus) {
                            return $state->label();
                        }

                        return $state ? (string) $state : 'Não enviado';
                    })
                    ->color(function ($state): string {
                        if ($state instanceof ProviderOrderStatus) {
                            return $state->color();
                        }

                        return 'gray';
                    })
                    ->sortable(),

                TextColumn::make('provider_charge')
                    ->label('Custo')
                    ->money('USD')
                    ->sortable()
                    ->placeholder('—'),

                TextColumn::make('provider_remains')
                    ->label('Restante')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('danger')
                    ->placeholder('—'),

                TextColumn::make('provider_order_sent_at')
                    ->label('Enviado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('—'),

                TextColumn::make('provider_last_check_at')
                    ->label('Última verificação')
                    ->since()
                    ->sortable()
                    ->placeholder('—'),

                TextColumn::make('created_at')
                    ->label('Criado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('provider_order_status')
                    ->label('Status')
                    ->options([
                        'Pending' => 'Pendente',
                        'Partial' => 'Parcial',
                        'Canceled' => 'Cancelado',
                        'Processing' => 'Processando',
                        'In progress' => 'Em Progresso',
                        'Completed' => 'Concluído',
                    ]),
            ])
            ->recordActions([
                CheckProviderStatusAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
