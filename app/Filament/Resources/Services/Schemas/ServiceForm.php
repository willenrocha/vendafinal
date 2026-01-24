<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Models\Provider;
use App\Models\Service;
use App\Services\PerfectPanel\PerfectPanelClient;
use Carbon\Carbon;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Arr;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Serviço')
                    ->columns(2)
                    ->schema([
                        Select::make('provider_id')
                            ->label('Provedor')
                            ->relationship('provider', 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function (Set $set): void {
                                $set('provider_service_id', null);
                            })
                            ->required(),

                        Select::make('provider_service_id')
                            ->label('Serviço do Provedor')
                            ->native(false)
                            ->searchable()
                            ->placeholder('Selecione um provedor primeiro')
                            ->loadingMessage('Carregando serviços...')
                            ->noSearchResultsMessage('Nenhum serviço encontrado')
                            ->disabled(fn (Get $get): bool => blank($get('provider_id')))
                            ->live()
                            ->afterStateUpdated(function (?string $state, Get $get, Set $set): void {
                                $providerId = (int) $get('provider_id');
                                $providerServiceId = (int) $state;

                                if ($providerId <= 0 || $providerServiceId <= 0) {
                                    $set('provider_name', null);
                                    $set('provider_category', null);
                                    $set('provider_type', null);
                                    $set('provider_rate', null);
                                    $set('provider_min', null);
                                    $set('provider_max', null);
                                    $set('provider_refill', false);
                                    $set('provider_cancel', false);
                                    $set('provider_synced_at', null);
                                    $set('last_error', null);
                                    $set('last_error_at', null);

                                    return;
                                }

                                $provider = Provider::query()->find($providerId);

                                if (! $provider) {
                                    return;
                                }

                                try {
                                    $client = new PerfectPanelClient($provider);
                                    $items = $client->servicesArray();

                                    $matched = null;
                                    foreach ($items as $item) {
                                        if (! is_array($item)) {
                                            continue;
                                        }
                                        if ((int) ($item['service'] ?? 0) === $providerServiceId) {
                                            $matched = $item;
                                            break;
                                        }
                                    }

                                    if (! is_array($matched)) {
                                        return;
                                    }

                                    $set('provider_name', (string) Arr::get($matched, 'name', ''));
                                    $set('provider_type', Arr::get($matched, 'type'));
                                    $set('provider_category', Arr::get($matched, 'category'));
                                    $set('provider_rate', Arr::get($matched, 'rate'));
                                    $set('provider_min', Arr::get($matched, 'min') !== null ? (int) Arr::get($matched, 'min') : null);
                                    $set('provider_max', Arr::get($matched, 'max') !== null ? (int) Arr::get($matched, 'max') : null);
                                    $set('provider_refill', (bool) Arr::get($matched, 'refill', false));
                                    $set('provider_cancel', (bool) Arr::get($matched, 'cancel', false));
                                    $set('provider_synced_at', Carbon::now()->toDateTimeString());
                                    $set('last_error', null);
                                    $set('last_error_at', null);
                                } catch (\Throwable $e) {
                                    $set('last_error', $e->getMessage());
                                    $set('last_error_at', Carbon::now()->toDateTimeString());
                                }
                            })
                            ->options(function (Get $get): array {
                                $providerId = (int) $get('provider_id');

                                if ($providerId <= 0) {
                                    return [];
                                }

                                $provider = Provider::query()->find($providerId);

                                if (! $provider) {
                                    return [];
                                }

                                $client = new PerfectPanelClient($provider);
                                $items = $client->servicesArray();

                                $options = [];

                                foreach ($items as $item) {
                                    if (! is_array($item)) {
                                        continue;
                                    }

                                    $id = (int) ($item['service'] ?? 0);
                                    if ($id <= 0) {
                                        continue;
                                    }

                                    $name = (string) ($item['name'] ?? "Serviço #{$id}");
                                    $category = (string) ($item['category'] ?? '');
                                    $rate = (string) ($item['rate'] ?? '');
                                    $min = (string) ($item['min'] ?? '');
                                    $max = (string) ($item['max'] ?? '');

                                    $label = "#{$id} — {$name}";
                                    if (filled($category)) {
                                        $label .= " — {$category}";
                                    }
                                    if (filled($rate)) {
                                        $label .= " (rate: {$rate})";
                                    }
                                    if (filled($min) || filled($max)) {
                                        $label .= " [{$min}-{$max}]";
                                    }

                                    $options[$id] = $label;
                                }

                                ksort($options);

                                return $options;
                            })
                            ->required(),

                        Hidden::make('provider_name'),
                        Hidden::make('provider_type'),
                        Hidden::make('provider_category'),
                        Hidden::make('provider_rate'),
                        Hidden::make('provider_min'),
                        Hidden::make('provider_max'),
                        Hidden::make('provider_refill'),
                        Hidden::make('provider_cancel'),
                        Hidden::make('provider_synced_at'),
                        Hidden::make('last_error'),
                        Hidden::make('last_error_at'),

                        TextInput::make('name')
                            ->label('Nome (nosso)')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Select::make('social_network')
                            ->label('Rede social')
                            ->options([
                                'instagram' => 'Instagram',
                                'tiktok' => 'TikTok',
                                'youtube' => 'YouTube',
                                'facebook' => 'Facebook',
                                'x' => 'X (Twitter)',
                                'telegram' => 'Telegram',
                                'kwai' => 'Kwai',
                                'other' => 'Outro',
                            ])
                            ->searchable(),

                        Toggle::make('is_active')
                            ->label('Ativo')
                            ->default(true),
                    ]),

                Section::make('Dados do Provedor (sync)')
                    ->columns(3)
                    ->collapsed(fn (string $operation): bool => $operation === 'create')
                    ->schema([
                        Placeholder::make('provider_name')
                            ->label('Nome (provedor)')
                            ->content(fn (?Service $record): string => $record?->provider_name ?: '—')
                            ->columnSpanFull(),

                        Placeholder::make('provider_category')
                            ->label('Categoria')
                            ->content(fn (?Service $record): string => $record?->provider_category ?: '—'),

                        Placeholder::make('provider_type')
                            ->label('Tipo')
                            ->content(fn (?Service $record): string => $record?->provider_type ?: '—'),

                        Placeholder::make('provider_rate')
                            ->label('Rate')
                            ->content(function (?Service $record): string {
                                if (! $record?->provider_rate) {
                                    return '—';
                                }

                                return (string) $record->provider_rate;
                            }),

                        Placeholder::make('provider_min')
                            ->label('Min')
                            ->content(fn (?Service $record): string => $record?->provider_min !== null ? (string) $record->provider_min : '—'),

                        Placeholder::make('provider_max')
                            ->label('Max')
                            ->content(fn (?Service $record): string => $record?->provider_max !== null ? (string) $record->provider_max : '—'),

                        Placeholder::make('provider_refill')
                            ->label('Refill')
                            ->content(fn (?Service $record): string => $record?->provider_refill ? 'Sim' : 'Não'),

                        Placeholder::make('provider_cancel')
                            ->label('Cancel')
                            ->content(fn (?Service $record): string => $record?->provider_cancel ? 'Sim' : 'Não'),

                        Placeholder::make('provider_synced_at')
                            ->label('Sincronizado em')
                            ->content(fn (?Service $record): string => $record?->provider_synced_at?->toDateTimeString() ?: '—'),
                    ]),
            ]);
    }
}
