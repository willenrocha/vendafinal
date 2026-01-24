<?php

namespace App\Services\Providers;

use App\Models\Provider;
use App\Models\Service;
use App\Services\PerfectPanel\PerfectPanelClient;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class ProviderService
{
    public function updateBalance(Provider $provider): Provider
    {
        $client = new PerfectPanelClient($provider);

        try {
            $response = $client->balance();

            $provider->forceFill([
                'balance' => data_get($response, 'balance'),
                'currency' => data_get($response, 'currency'),
                'balance_synced_at' => Carbon::now(),
                'last_error' => null,
                'last_error_at' => null,
            ])->save();
        } catch (\Throwable $e) {
            $provider->forceFill([
                'last_error' => $e->getMessage(),
                'last_error_at' => Carbon::now(),
            ])->save();

            throw $e;
        }

        return $provider;
    }

    /**
     * Importa APENAS os serviços selecionados (por provider_service_id).
     *
     * @param  array<int>  $providerServiceIds
     */
    public function importServices(Provider $provider, array $providerServiceIds, ?string $socialNetwork = null): void
    {
        $providerServiceIds = array_values(array_unique(array_map('intval', $providerServiceIds)));

        if ($providerServiceIds === []) {
            return;
        }

        $servicesById = $this->fetchProviderServicesById($provider);

        foreach ($providerServiceIds as $providerServiceId) {
            $payload = $servicesById[$providerServiceId] ?? null;

            if (! is_array($payload)) {
                continue;
            }

            Service::query()->updateOrCreate(
                [
                    'provider_id' => $provider->id,
                    'provider_service_id' => $providerServiceId,
                ],
                [
                    'name' => (string) ($payload['name'] ?? "Serviço #{$providerServiceId}"),
                    'social_network' => $socialNetwork,
                    'is_active' => true,

                    ...$this->mapProviderServicePayloadToAttributes($payload),
                    'provider_synced_at' => Carbon::now(),
                    'last_error' => null,
                    'last_error_at' => null,
                ],
            );
        }
    }

    /** Sincroniza um serviço local (atualiza somente os campos "importantes" vindos do provedor). */
    public function syncService(Service $service): Service
    {
        $provider = $service->provider;

        $servicesById = $this->fetchProviderServicesById($provider);
        $payload = $servicesById[(int) $service->provider_service_id] ?? null;

        if (! is_array($payload)) {
            $service->forceFill([
                'last_error' => 'Serviço não encontrado no provedor (services).',
                'last_error_at' => Carbon::now(),
            ])->save();

            return $service;
        }

        try {
            $service->forceFill([
                ...$this->mapProviderServicePayloadToAttributes($payload),
                'provider_synced_at' => Carbon::now(),
                'last_error' => null,
                'last_error_at' => null,
            ])->save();
        } catch (\Throwable $e) {
            $service->forceFill([
                'last_error' => $e->getMessage(),
                'last_error_at' => Carbon::now(),
            ])->save();

            throw $e;
        }

        return $service;
    }

    /** Sincroniza todos os serviços já cadastrados para um provedor. */
    public function syncServicesForProvider(Provider $provider): void
    {
        $servicesById = $this->fetchProviderServicesById($provider);

        $provider->services()->get()->each(function (Service $service) use ($servicesById): void {
            $payload = $servicesById[(int) $service->provider_service_id] ?? null;

            if (! is_array($payload)) {
                $service->forceFill([
                    'last_error' => 'Serviço não encontrado no provedor (services).',
                    'last_error_at' => Carbon::now(),
                ])->save();

                return;
            }

            $service->forceFill([
                ...$this->mapProviderServicePayloadToAttributes($payload),
                'provider_synced_at' => Carbon::now(),
                'last_error' => null,
                'last_error_at' => null,
            ])->save();
        });
    }

    /** @return array<int, array<string, mixed>> */
    protected function fetchProviderServicesById(Provider $provider): array
    {
        $client = new PerfectPanelClient($provider);

        $items = $client->servicesArray();

        $servicesById = [];

        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            $id = (int) ($item['service'] ?? 0);

            if ($id <= 0) {
                continue;
            }

            $servicesById[$id] = $item;
        }

        return $servicesById;
    }

    /** @param  array<string, mixed>  $payload */
    protected function mapProviderServicePayloadToAttributes(array $payload): array
    {
        return [
            'provider_name' => (string) Arr::get($payload, 'name', ''),
            'provider_type' => Arr::get($payload, 'type'),
            'provider_category' => Arr::get($payload, 'category'),
            'provider_rate' => Arr::get($payload, 'rate'),
            'provider_min' => Arr::get($payload, 'min') !== null ? (int) Arr::get($payload, 'min') : null,
            'provider_max' => Arr::get($payload, 'max') !== null ? (int) Arr::get($payload, 'max') : null,
            'provider_refill' => (bool) Arr::get($payload, 'refill', false),
            'provider_cancel' => (bool) Arr::get($payload, 'cancel', false),
        ];
    }
}
