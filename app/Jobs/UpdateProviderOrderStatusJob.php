<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\ProviderOrderStatus;
use App\Models\ProviderOrder;
use App\Services\PerfectPanel\PerfectPanelClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateProviderOrderStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $timeout = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $providerOrderId,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $providerOrder = ProviderOrder::with(['service.provider'])->find($this->providerOrderId);

        if (! $providerOrder) {
            Log::warning('UpdateProviderOrderStatusJob: ProviderOrder not found', [
                'provider_order_id' => $this->providerOrderId,
            ]);

            return;
        }

        // Verifica se o pedido foi enviado ao provedor
        if (! $providerOrder->provider_order_id) {
            Log::info('UpdateProviderOrderStatusJob: Order not sent to provider yet', [
                'provider_order_id' => $providerOrder->id,
            ]);

            return;
        }

        // Se já está completo, cancelado ou parcial, não precisa verificar mais
        if (in_array($providerOrder->provider_order_status?->value, ['Completed', 'Canceled', 'Partial'])) {
            Log::info('UpdateProviderOrderStatusJob: Order already in final status', [
                'provider_order_id' => $providerOrder->id,
                'status' => $providerOrder->provider_order_status->value,
            ]);

            return;
        }

        // Validações
        if (! $providerOrder->service?->provider) {
            Log::error('UpdateProviderOrderStatusJob: Missing provider', [
                'provider_order_id' => $providerOrder->id,
            ]);

            return;
        }

        $provider = $providerOrder->service->provider;

        try {
            $client = new PerfectPanelClient($provider);
            $response = $client->checkOrderStatus($providerOrder->provider_order_id);

            // Normaliza o status retornado
            $statusValue = (string) ($response->status ?? '');
            $providerStatus = match ($statusValue) {
                'Pending' => ProviderOrderStatus::Pending,
                'Partial' => ProviderOrderStatus::Partial,
                'Canceled' => ProviderOrderStatus::Canceled,
                'Processing' => ProviderOrderStatus::Processing,
                'In progress' => ProviderOrderStatus::InProgress,
                'Completed' => ProviderOrderStatus::Completed,
                default => null,
            };

            // Atualiza dados do pedido
            $providerOrder->forceFill([
                'provider_order_status' => $providerStatus,
                'provider_charge' => isset($response->charge) ? (float) $response->charge : null,
                'provider_start_count' => isset($response->start_count) ? (int) $response->start_count : null,
                'provider_remains' => isset($response->remains) ? (int) $response->remains : null,
                'provider_currency' => (string) ($response->currency ?? null),
                'provider_last_check_at' => now(),
            ])->save();

            Log::info('UpdateProviderOrderStatusJob: Status updated successfully', [
                'provider_order_id' => $providerOrder->id,
                'provider_api_order_id' => $providerOrder->provider_order_id,
                'status' => $statusValue,
                'remains' => $providerOrder->provider_remains,
                'charge' => $providerOrder->provider_charge,
            ]);

            // Se não está em status final, agenda nova verificação em 5 minutos
            if ($providerStatus && ! in_array($providerStatus->value, ['Completed', 'Canceled', 'Partial'])) {
                self::dispatch($providerOrder->id)->delay(now()->addMinutes(5));
            }
        } catch (\Exception $e) {
            Log::error('UpdateProviderOrderStatusJob: Failed to check status', [
                'provider_order_id' => $providerOrder->id,
                'provider_api_order_id' => $providerOrder->provider_order_id,
                'error' => $e->getMessage(),
            ]);

            throw $e; // Rejoga exceção para retry automático
        }
    }
}
