<?php

declare(strict_types=1);

namespace App\Services\Credits;

use App\Enums\OrderStatus;
use App\Jobs\UpdateProviderOrderStatusJob;
use App\Models\InstagramPost;
use App\Models\Order;
use App\Models\ProviderOrder;
use App\Models\Service;
use App\Models\User;
use App\Services\PerfectPanel\PerfectPanelClient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreditRedemptionService
{
    public function __construct(
        protected UserCreditService $creditService,
    ) {}

    public function redeem(User $user, InstagramPost $post, string $creditType, int $amount): ProviderOrder
    {
        // Busca o serviço configurado para esse tipo de crédito
        $service = Service::where('credit_type', $creditType)
            ->where('is_active', true)
            ->first();

        if (! $service) {
            throw new \InvalidArgumentException("Nenhum serviço configurado para créditos de {$creditType}.");
        }

        if (! $service->provider) {
            throw new \InvalidArgumentException('Serviço sem provedor configurado.');
        }

        return DB::transaction(function () use ($user, $post, $creditType, $amount, $service) {
            // Debita créditos (lança exceção se insuficiente)
            $this->creditService->deduct($user, $creditType, $amount);

            // Cria Order com amount=0 marcada como resgate de crédito
            $order = Order::create([
                'user_id' => $user->id,
                'instagram_profile_id' => $post->instagram_profile_id,
                'instagram_username' => $post->profile?->username,
                'status' => OrderStatus::Paid,
                'is_credit_redemption' => true,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'amount' => 0,
                'currency' => 'BRL',
                'paid_at' => now(),
            ]);

            // Cria ProviderOrder
            $providerOrder = ProviderOrder::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'service_id' => $service->id,
                'instagram_profile_id' => $post->instagram_profile_id,
                'quantity' => $amount,
            ]);

            // Envia ao provedor
            $link = "https://instagram.com/p/{$post->shortcode}";

            try {
                $client = new PerfectPanelClient($service->provider);
                $response = $client->createOrder(
                    (string) $service->provider_service_id,
                    $link,
                    $amount,
                );

                $providerOrder->forceFill([
                    'provider_order_id' => (string) ($response->order ?? $response->order_id ?? null),
                    'provider_order_sent_at' => now(),
                ])->save();

                // Agenda verificação de status
                UpdateProviderOrderStatusJob::dispatch($providerOrder->id)->delay(now()->addMinutes(2));

                Log::info('CreditRedemptionService: Credits redeemed', [
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                    'credit_type' => $creditType,
                    'amount' => $amount,
                    'order_id' => $order->id,
                    'provider_order_id' => $providerOrder->id,
                ]);
            } catch (\Exception $e) {
                Log::error('CreditRedemptionService: Failed to send to provider', [
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                    'error' => $e->getMessage(),
                ]);
                // O pedido foi criado mas falhou ao enviar — será retentado manualmente
            }

            return $providerOrder;
        });
    }
}
