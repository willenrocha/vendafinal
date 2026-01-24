<?php

namespace App\Filament\Pages;

use App\Enums\OrderStatus;
use App\Models\Order;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use BackedEnum;
use UnitEnum;

class Leads extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|UnitEnum|null $navigationGroup = 'Vendas';

    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return 'Leads';
    }

    public function getTitle(): string
    {
        return 'Gerenciamento de Leads';
    }

    public function getView(): string
    {
        return 'filament.pages.leads';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->where('status', OrderStatus::AwaitingPayment)
                    ->orderBy('contacted_at', 'asc')
                    ->orderBy('created_at', 'desc')
            )
            ->columns([
                TextColumn::make('public_code')
                    ->label('Código')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->badge()
                    ->color('gray'),

                TextColumn::make('customer_name')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('customer_email')
                    ->label('E-mail')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('customer_phone')
                    ->label('Telefone')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('instagram_username')
                    ->label('Instagram')
                    ->formatStateUsing(fn (?string $state): string => $state ? '@' . $state : '—')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('package.name')
                    ->label('Pacote')
                    ->searchable(),

                TextColumn::make('amount')
                    ->label('Valor')
                    ->money('BRL')
                    ->sortable(),

                IconColumn::make('contacted_at')
                    ->label('Contatado')
                    ->boolean()
                    ->trueIcon(Heroicon::OutlinedCheckCircle)
                    ->falseIcon(Heroicon::OutlinedXCircle)
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                TextColumn::make('contacted_by')
                    ->label('Contatado por')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
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
            ->defaultSort('contacted_at', 'asc')
            ->recordActions([
                \App\Filament\Resources\Orders\Actions\MarkAsContactedAction::make(),
                \App\Filament\Resources\Orders\Actions\ViewContactNotesAction::make(),
                \App\Filament\Resources\Orders\Actions\ConfirmPaymentAction::make(),
                \App\Filament\Resources\Orders\Actions\CancelOrderAction::make(),
                \App\Filament\Resources\Orders\Actions\ResendPixAction::make(),
            ])
            ->toolbarActions([
                \App\Filament\Resources\Orders\Actions\ExportLeadsAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \App\Filament\Resources\Orders\Actions\BulkMarkAsContactedAction::make(),
                ]),
            ]);
    }
}
