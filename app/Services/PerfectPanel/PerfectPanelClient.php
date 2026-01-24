<?php

namespace App\Services\PerfectPanel;

use App\Models\Provider;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PerfectPanelClient
{
    public function __construct(
        protected Provider $provider,
    ) {
    }

    protected function http(): PendingRequest
    {
        return Http::asForm()
            ->acceptJson()
            ->timeout(20);
    }

    protected function connect(array $payload): string
    {
        return $this->http()
            ->post($this->provider->api_url, $payload)
            ->throw()
            ->body();
    }

    /** Get balance */
    public function balance()
    {
        return json_decode(
            $this->connect([
                'key' => $this->provider->api_key,
                'action' => 'balance',
            ])
        );
    }

    public function services()
    {
        return json_decode(
            $this->connect([
                'key' => $this->provider->api_key,
                'action' => 'services',
            ])
        );
    }

    /** @return array<int, array<string, mixed>> */
    public function servicesArray(int $ttlSeconds = 300): array
    {
        $cacheKey = sprintf('perfectpanel:provider:%d:services', (int) $this->provider->id);

        return Cache::remember($cacheKey, $ttlSeconds, function (): array {
            $response = $this->services();
            $items = json_decode(json_encode($response), true);

            return is_array($items) ? $items : [];
        });
    }

    /**
     * Cria um pedido no provedor
     *
     * @param  string  $serviceId  ID do serviço no provedor
     * @param  string  $link  Link do perfil do Instagram
     * @param  int  $quantity  Quantidade desejada
     * @return object Resposta da API com order_id
     */
    public function createOrder(string $serviceId, string $link, int $quantity): object
    {
        $response = $this->connect([
            'key' => $this->provider->api_key,
            'action' => 'add',
            'service' => $serviceId,
            'link' => $link,
            'quantity' => $quantity,
        ]);

        return json_decode($response);
    }

    /**
     * Verifica o status de um pedido no provedor
     *
     * @param  string  $orderId  ID do pedido no provedor
     * @return object Resposta da API com charge, start_count, status, remains, currency
     */
    public function checkOrderStatus(string $orderId): object
    {
        $response = $this->connect([
            'key' => $this->provider->api_key,
            'action' => 'status',
            'order' => $orderId,
        ]);

        return json_decode($response);
    }
}
