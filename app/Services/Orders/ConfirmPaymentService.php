<?php

declare(strict_types=1);

namespace App\Services\Orders;

use App\Enums\OrderStatus;
use App\Jobs\SendOrderToProviderJob;
use App\Jobs\SyncInstagramProfileJob;
use App\Models\Order;
use App\Models\User;
use App\Notifications\CustomerAccountCreatedNotification;
use App\Notifications\OrderStatusChangedNotification;
use App\Services\Credits\UserCreditService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class ConfirmPaymentService
{
    public function __construct(
        protected UserCreditService $creditService,
    ) {}

    public function handle(Order $order): void
    {
        // Guard: evita processar pedido já pago
        if (($order->status?->value ?? (string) $order->status) === OrderStatus::Paid->value) {
            return;
        }

        $previous = $order->status;

        $order->forceFill([
            'status' => OrderStatus::Paid,
            'paid_at' => now(),
            'cancelled_at' => null,
        ])->save();

        // Cria usuário cliente somente após pagamento.
        $user = $order->user;
        if (! $user) {
            $user = User::query()->where('email', $order->customer_email)->first();
        }

        $temporaryPassword = null;

        if ($user && (bool) ($user->is_admin ?? false)) {
            // Segurança: nunca mexe em admin.
            $user = null;
        }

        if (! $user) {
            $temporaryPassword = Str::password(12);

            $user = User::create([
                'name' => $order->customer_name,
                'email' => $order->customer_email,
                'password' => Hash::make($temporaryPassword),
                'is_admin' => false,
            ]);
        } else {
            // Se já existe cliente, garante uma senha temporária nova para acesso.
            $temporaryPassword = Str::password(12);
            $user->forceFill([
                'password' => Hash::make($temporaryPassword),
            ])->save();
        }

        // Associa o usuário ao pedido
        $order->forceFill([
            'user_id' => $user->id,
        ])->save();

        if (is_string($temporaryPassword) && $temporaryPassword !== '') {
            Notification::route('mail', (string) $order->customer_email)
                ->notify(new CustomerAccountCreatedNotification(
                    order: $order,
                    temporaryPassword: $temporaryPassword,
                    loginUrl: (string) config('services.client.app_url', ''),
                ));
        }

        // Adiciona créditos/bônus do pacote ao usuário
        if ($user && $order->package) {
            $this->creditService->addPackageBonus($user, $order->package);
        }

        // Dispara job para sincronizar perfil do Instagram e posts
        if ($order->instagramProfile) {
            SyncInstagramProfileJob::dispatch($order->instagramProfile->id, postsLimit: 12);
        }

        // Dispara job para enviar pedido ao provedor (PerfectPanel)
        SendOrderToProviderJob::dispatch($order->id);

        Notification::route('mail', (string) $order->customer_email)
            ->notify(new OrderStatusChangedNotification($order, $previous));

        Log::info('ConfirmPaymentService: Payment confirmed', [
            'order_id' => $order->id,
            'user_id' => $user->id,
        ]);
    }
}
