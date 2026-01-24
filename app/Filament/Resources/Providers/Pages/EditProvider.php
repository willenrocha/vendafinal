<?php

namespace App\Filament\Resources\Providers\Pages;

use App\Filament\Resources\Providers\ProviderResource;
use App\Models\Provider;
use App\Services\Providers\ProviderService;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Resources\Pages\EditRecord;

class EditProvider extends EditRecord
{
    protected static string $resource = ProviderResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['name'] = trim((string) ($data['name'] ?? ''));
        $data['api_url'] = trim((string) ($data['api_url'] ?? ''));
        $data['api_key'] = trim((string) ($data['api_key'] ?? ''));

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('importServices')
                ->label('Importar serviços')
                ->icon(Heroicon::Plus)
                ->form([
                    Select::make('service_ids')
                        ->label('Serviços do provedor')
                        ->multiple()
                        ->searchable()
                        ->required()
                        ->options(function (Provider $record): array {
                            $client = new \App\Services\PerfectPanel\PerfectPanelClient($record);
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

                                $label = $name;
                                if (filled($category)) {
                                    $label .= " — {$category}";
                                }
                                if (filled($rate)) {
                                    $label .= " (rate: {$rate})";
                                }

                                $options[$id] = $label;
                            }

                            ksort($options);

                            return $options;
                        }),

                    Select::make('social_network')
                        ->label('Rede social (opcional)')
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
                ])
                ->action(function (Provider $record, array $data): void {
                    try {
                        app(ProviderService::class)->importServices(
                            $record,
                            $data['service_ids'] ?? [],
                            $data['social_network'] ?? null,
                        );

                        Notification::make()
                            ->success()
                            ->title('Serviços importados')
                            ->send();
                    } catch (\Throwable $e) {
                        Notification::make()
                            ->danger()
                            ->title('Falha ao importar serviços')
                            ->body($e->getMessage())
                            ->send();
                    }
                }),

            Action::make('syncServices')
                ->label('Sincronizar serviços')
                ->icon(Heroicon::ArrowPath)
                ->action(function (Provider $record): void {
                    try {
                        app(ProviderService::class)->syncServicesForProvider($record);

                        Notification::make()
                            ->success()
                            ->title('Serviços sincronizados')
                            ->send();
                    } catch (\Throwable $e) {
                        Notification::make()
                            ->danger()
                            ->title('Falha ao sincronizar serviços')
                            ->body($e->getMessage())
                            ->send();
                    }
                }),

            Action::make('syncBalance')
                ->label('Atualizar saldo')
                ->icon(Heroicon::ArrowPath)
                ->disabled(fn (Provider $record): bool => ! $record->is_active)
                ->action(function (Provider $record): void {
                    try {
                        app(ProviderService::class)->updateBalance($record);

                        Notification::make()
                            ->success()
                            ->title('Saldo atualizado')
                            ->send();
                    } catch (\Throwable $e) {
                        Notification::make()
                            ->danger()
                            ->title('Falha ao atualizar saldo')
                            ->body($e->getMessage())
                            ->send();
                    }
                }),
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
