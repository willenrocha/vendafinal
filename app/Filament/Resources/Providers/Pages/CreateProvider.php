<?php

namespace App\Filament\Resources\Providers\Pages;

use App\Filament\Resources\Providers\ProviderResource;
use App\Models\Provider;
use App\Services\Providers\ProviderService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Throwable;

class CreateProvider extends CreateRecord
{
    protected static string $resource = ProviderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['name'] = trim((string) ($data['name'] ?? ''));
        $data['api_url'] = trim((string) ($data['api_url'] ?? ''));
        $data['api_key'] = trim((string) ($data['api_key'] ?? ''));

        return $data;
    }

    protected function afterCreate(): void
    {
        /** @var Provider $provider */
        $provider = $this->record;

        if (! $provider->is_active) {
            return;
        }

        try {
            app(ProviderService::class)->updateBalance($provider);

            Notification::make()
                ->success()
                ->title('Provedor cadastrado e saldo sincronizado')
                ->send();
        } catch (Throwable $e) {
            $provider->forceFill(['is_active' => false])->save();

            Notification::make()
                ->danger()
                ->title('Provedor cadastrado, mas falhou ao validar a API')
                ->body($e->getMessage())
                ->send();
        }
    }
}
