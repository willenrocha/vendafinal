<?php

namespace App\Filament\Resources\Services\Pages;

use App\Filament\Resources\Services\ServiceResource;
use App\Models\Provider;
use App\Services\PerfectPanel\PerfectPanelClient;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Filament\Resources\Pages\CreateRecord;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (filled($data['provider_name'] ?? null)) {
            return $data;
        }

        $providerId = (int) ($data['provider_id'] ?? 0);
        $providerServiceId = (int) ($data['provider_service_id'] ?? 0);

        if ($providerId <= 0 || $providerServiceId <= 0) {
            return $data;
        }

        $provider = Provider::query()->find($providerId);

        if (! $provider) {
            return $data;
        }

        try {
            $client = new PerfectPanelClient($provider);
            $response = $client->services();
            $items = json_decode(json_encode($response), true);

            if (! is_array($items)) {
                return $data;
            }

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
                return $data;
            }

            $data['provider_name'] = (string) Arr::get($matched, 'name', '');
            $data['provider_type'] = Arr::get($matched, 'type');
            $data['provider_category'] = Arr::get($matched, 'category');
            $data['provider_rate'] = Arr::get($matched, 'rate');
            $data['provider_min'] = Arr::get($matched, 'min') !== null ? (int) Arr::get($matched, 'min') : null;
            $data['provider_max'] = Arr::get($matched, 'max') !== null ? (int) Arr::get($matched, 'max') : null;
            $data['provider_refill'] = (bool) Arr::get($matched, 'refill', false);
            $data['provider_cancel'] = (bool) Arr::get($matched, 'cancel', false);
            $data['provider_synced_at'] = Carbon::now();
        } catch (\Throwable $e) {
            // Não impede o cadastro se a API estiver fora, mas registra que não conseguiu sincronizar.
            $data['last_error'] = $e->getMessage();
            $data['last_error_at'] = Carbon::now();
        }

        return $data;
    }
}
