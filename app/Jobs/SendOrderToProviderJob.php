<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Order;
use App\Models\ProviderOrder;
use App\Services\PerfectPanel\PerfectPanelClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendOrderToProviderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $timeout = 120;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $orderId,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $order = Order::with(['package.primaryService.provider', 'instagramProfile', 'user'])
            ->find($this->orderId);

        if (! $order) {
            Log::warning('SendOrderToProviderJob: Order not found', ['order_id' => $this->orderId]);

            return;
        }

        // Validações
        if (! $order->package) {
            Log::error('SendOrderToProviderJob: Order has no package', ['order_id' => $order->id]);

            return;
        }

        if (! $order->package->primaryService) {
            Log::error('SendOrderToProviderJob: Package has no primary service', [
                'order_id' => $order->id,
                'package_id' => $order->package->id,
            ]);

            return;
        }

        if (! $order->package->primaryService->provider) {
            Log::error('SendOrderToProviderJob: Service has no provider', [
                'order_id' => $order->id,
                'service_id' => $order->package->primaryService->id,
            ]);

            return;
        }

        if (! $order->instagramProfile) {
            Log::error('SendOrderToProviderJob: Order has no instagram profile', ['order_id' => $order->id]);

            return;
        }

        if (! $order->user) {
            Log::error('SendOrderToProviderJob: Order has no user', ['order_id' => $order->id]);

            return;
        }

        $service = $order->package->primaryService;
        $provider = $service->provider;

        // Cria o ProviderOrder
        $providerOrder = ProviderOrder::create([
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'package_id' => $order->package_id,
            'service_id' => $service->id,
            'instagram_profile_id' => $order->instagram_profile_id,
            'quantity' => (int) $order->package->display_max,
        ]);

        // Prepara dados do pedido
        $serviceId = (string) $service->provider_service_id;
        $link = 'https://instagram.com/'.$order->instagramProfile->username;
        $quantity = $providerOrder->quantity;

        try {
            $client = new PerfectPanelClient($provider);
            $response = $client->createOrder($serviceId, $link, $quantity);

            // Salva o ID do pedido retornado pelo provedor
            $providerOrder->forceFill([
                'provider_order_id' => (string) ($response->order ?? $response->order_id ?? null),
                'provider_order_sent_at' => now(),
            ])->save();

            Log::info('SendOrderToProviderJob: Order sent successfully', [
                'order_id' => $order->id,
                'provider_order_id' => $providerOrder->id,
                'provider_api_order_id' => $providerOrder->provider_order_id,
                'service_id' => $serviceId,
                'quantity' => $quantity,
                'link' => $link,
            ]);

            // Agenda primeira verificação de status em 2 minutos
            UpdateProviderOrderStatusJob::dispatch($providerOrder->id)->delay(now()->addMinutes(2));
        } catch (\Exception $e) {
            Log::error('SendOrderToProviderJob: Failed to send order', [
                'order_id' => $order->id,
                'provider_order_id' => $providerOrder->id,
                'error' => $e->getMessage(),
                'service_id' => $serviceId,
                'quantity' => $quantity,
                'link' => $link,
            ]);

            throw $e; // Rejoga exceção para retry automático
        }
    }
}
