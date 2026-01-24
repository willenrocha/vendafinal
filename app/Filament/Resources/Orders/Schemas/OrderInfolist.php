<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Enums\OrderStatus;
use App\Enums\ProviderOrderStatus;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Pedido')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('public_code')
                            ->label('Código')
                            ->badge()
                            ->copyable()
                            ->color('gray'),

                        TextEntry::make('status')
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
                            }),

                        TextEntry::make('package.name')
                            ->label('Pacote')
                            ->columnSpanFull(),

                        TextEntry::make('amount')
                            ->label('Total')
                            ->money('BRL'),

                        TextEntry::make('instagram_username')
                            ->label('Instagram')
                            ->formatStateUsing(fn (?string $state): string => $state ? '@' . $state : '—')
                            ->columnSpanFull(),

                        TextEntry::make('customer_name')
                            ->label('Nome')
                            ->columnSpanFull(),

                        TextEntry::make('customer_email')
                            ->label('E-mail')
                            ->columnSpanFull(),

                        TextEntry::make('customer_phone')
                            ->label('Telefone')
                            ->columnSpanFull(),

                        TextEntry::make('created_at')
                            ->label('Criado em')
                            ->dateTime(),

                        TextEntry::make('paid_at')
                            ->label('Pago em')
                            ->dateTime(),

                        TextEntry::make('cancelled_at')
                            ->label('Cancelado em')
                            ->dateTime(),
                    ]),

                Section::make('Pix')
                    ->columns(1)
                    ->schema([
                        TextEntry::make('pix_generated_at')
                            ->label('Gerado em')
                            ->dateTime(),

                        TextEntry::make('pix_brcode')
                            ->label('Copia e cola')
                            ->copyable()
                            ->placeholder('—'),
                    ]),

                Section::make('Provedor')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('package.primaryService.provider.id')
                            ->label('ID do Provedor')
                            ->badge()
                            ->color('gray')
                            ->placeholder('—'),

                        TextEntry::make('package.primaryService.provider.name')
                            ->label('Nome do Provedor')
                            ->badge()
                            ->color('info')
                            ->placeholder('—'),

                        TextEntry::make('package.primaryService.provider_service_id')
                            ->label('ID do Serviço')
                            ->badge()
                            ->color('warning')
                            ->placeholder('—'),

                        TextEntry::make('package.primaryService.name')
                            ->label('Nome do Serviço')
                            ->columnSpanFull()
                            ->placeholder('—'),
                    ])
                    ->visible(fn ($record) => $record->package?->primaryService !== null),

                Section::make('Pedidos ao Provedor')
                    ->description(fn ($record) => 'Pedidos enviados ao provedor para este order')
                    ->schema([
                        RepeatableEntry::make('providerOrders')
                            ->label('')
                            ->state(fn ($record) => $record->providerOrders)
                            ->schema([
                                TextEntry::make('public_code')
                                    ->label('Código')
                                    ->copyable()
                                    ->badge()
                                    ->color('gray'),

                                TextEntry::make('service.name')
                                    ->label('Serviço')
                                    ->badge()
                                    ->color('info'),

                                TextEntry::make('provider_order_status')
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
                                    }),

                                TextEntry::make('provider_order_id')
                                    ->label('ID API')
                                    ->copyable()
                                    ->badge()
                                    ->color('warning')
                                    ->placeholder('—'),

                                TextEntry::make('quantity')
                                    ->label('Quantidade')
                                    ->numeric()
                                    ->badge(),

                                TextEntry::make('provider_charge')
                                    ->label('Custo')
                                    ->money('USD')
                                    ->placeholder('—'),

                                TextEntry::make('provider_remains')
                                    ->label('Restante')
                                    ->numeric()
                                    ->badge()
                                    ->color('danger')
                                    ->placeholder('—'),

                                TextEntry::make('provider_order_sent_at')
                                    ->label('Enviado')
                                    ->dateTime('d/m/Y H:i')
                                    ->placeholder('—'),

                                TextEntry::make('provider_last_check_at')
                                    ->label('Última verificação')
                                    ->since()
                                    ->placeholder('—'),
                            ])
                            ->columns(4),
                    ])
                    ->visible(fn ($record) => $record->providerOrders()->count() > 0)
                    ->collapsible(),

                Section::make('Bônus inclusos')
                    ->columns(1)
                    ->schema([
                        TextEntry::make('bonus_list')
                            ->label('')
                            ->listWithLineBreaks()
                            ->bulleted()
                            ->state(function ($record) {
                                $bonusItems = $record->package?->bonusItems ?? collect();
                                $bonusItems = $bonusItems->where('is_active', true);

                                if ($bonusItems->isEmpty()) {
                                    return ['Nenhum bônus incluído'];
                                }

                                return $bonusItems->map(function ($bonus) {
                                    $label = (string) ($bonus->label ?? '');
                                    if ($label !== '') {
                                        return $label;
                                    }

                                    $amount = number_format((int) $bonus->amount, 0, ',', '.');
                                    $type = match ((string) $bonus->credit_type) {
                                        'likes' => 'Curtidas',
                                        'views' => 'Visualizações',
                                        'comments' => 'Comentários',
                                        default => 'Bônus',
                                    };

                                    return $amount . ' ' . $type;
                                })->values()->toArray();
                            }),
                    ])
                    ->visible(fn ($record) => $record->package?->bonusItems()->where('is_active', true)->exists()),
            ]);
    }
}
