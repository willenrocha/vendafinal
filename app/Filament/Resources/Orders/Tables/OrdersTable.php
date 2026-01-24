<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Enums\OrderStatus;
use App\Enums\ProviderOrderStatus;
use App\Filament\Resources\Orders\Actions\BulkMarkAsContactedAction;
use App\Filament\Resources\Orders\Actions\CancelOrderAction;
use App\Filament\Resources\Orders\Actions\ConfirmPaymentAction;
use App\Filament\Resources\Orders\Actions\ExportLeadsAction;
use App\Filament\Resources\Orders\Actions\MarkAsContactedAction;
use App\Filament\Resources\Orders\Actions\ResendCredentialsAction;
use App\Filament\Resources\Orders\Actions\ResendPixAction;
use App\Filament\Resources\Orders\Actions\ViewContactNotesAction;
use App\Models\Order;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrdersTable
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

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(function ($state): string {
                        if ($state instanceof OrderStatus) {
                            return $state->label();
                        }

                        return (string) $state;
                    })
                    ->color(function ($state): string {
                        $value = $state instanceof OrderStatus ? $state->value : (string) $state;

                        return match ($value) {
                            OrderStatus::Paid->value => 'success',
                            OrderStatus::AwaitingPayment->value => 'warning',
                            OrderStatus::Cancelled->value => 'danger',
                            default => 'gray',
                        };
                    })
                    ->sortable(),

                TextColumn::make('package.name')
                    ->label('Pacote')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('providerOrders')
                    ->label('Pedidos Provedor')
                    ->badge()
                    ->formatStateUsing(fn ($record) => $record->providerOrders()->count())
                    ->color('info')
                    ->placeholder('0'),

                TextColumn::make('amount')
                    ->label('Total')
                    ->money('BRL')
                    ->sortable(),

                TextColumn::make('customer_name')
                    ->label('Cliente')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('customer_email')
                    ->label('E-mail')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('instagram_username')
                    ->label('Instagram')
                    ->formatStateUsing(fn (?string $state): string => $state ? '@' . $state : '—')
                    ->searchable()
                    ->toggleable(),

                IconColumn::make('contacted_at')
                    ->label('Contatado')
                    ->boolean()
                    ->trueIcon(Heroicon::OutlinedCheckCircle)
                    ->falseIcon(Heroicon::OutlinedXCircle)
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Criado')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        OrderStatus::AwaitingPayment->value => OrderStatus::AwaitingPayment->label(),
                        OrderStatus::Paid->value => OrderStatus::Paid->label(),
                        OrderStatus::Cancelled->value => OrderStatus::Cancelled->label(),
                        OrderStatus::Expired->value => OrderStatus::Expired->label(),
                    ]),

                Filter::make('created_at')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('created_from')
                            ->label('Criado de'),
                        \Filament\Forms\Components\DatePicker::make('created_until')
                            ->label('Criado até'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),

                Filter::make('paid_at')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('paid_from')
                            ->label('Pago de'),
                        \Filament\Forms\Components\DatePicker::make('paid_until')
                            ->label('Pago até'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['paid_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('paid_at', '>=', $date),
                            )
                            ->when(
                                $data['paid_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('paid_at', '<=', $date),
                            );
                    }),

                TernaryFilter::make('contacted')
                    ->label('Status de Contato')
                    ->placeholder('Todos')
                    ->trueLabel('Contatados')
                    ->falseLabel('Não Contatados')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('contacted_at'),
                        false: fn (Builder $query) => $query->whereNull('contacted_at'),
                        blank: fn (Builder $query) => $query,
                    ),
            ])
            ->recordActions([
                MarkAsContactedAction::make(),
                ViewContactNotesAction::make(),
                ConfirmPaymentAction::make(),
                CancelOrderAction::make(),
                ResendCredentialsAction::make(),
                ResendPixAction::make(),
            ])
            ->toolbarActions([
                ExportLeadsAction::make(),
                BulkActionGroup::make([
                    BulkMarkAsContactedAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
