<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Jobs\SendOrderToProviderJob;
use App\Models\Order;
use App\Notifications\OrderStatusChangedNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ExpayWebhookController extends Controller
{
    /**
     * Recebe notificações de pagamento da Expay
     */
    public function handle(Request $request): JsonResponse
    {
        Log::info('Expay Webhook received', $request->all());

        // Validação básica dos dados recebidos
        $transactionId = $request->input('transaction_id');
        $status = $request->input('status');
        $orderId = $request->input('order_id');

        if (!$transactionId || !$status || !$orderId) {
            Log::warning('Expay Webhook: Dados incompletos', $request->all());
            return response()->json(['message' => 'Dados incompletos'], 400);
        }

        // Busca o pedido
        $order = Order::where('id', $orderId)
            ->orWhere('payment_gateway_transaction_id', $transactionId)
            ->first();

        if (!$order) {
            Log::warning('Expay Webhook: Pedido não encontrado', [
                'order_id' => $orderId,
                'transaction_id' => $transactionId,
            ]);
            return response()->json(['message' => 'Pedido não encontrado'], 404);
        }

        // Atualiza o payment_gateway_data com os dados do webhook
        $gatewayData = $order->payment_gateway_data ?? [];
        $gatewayData['webhook_data'] = $request->all();
        $gatewayData['last_webhook_at'] = now()->toIso8601String();
        $order->payment_gateway_data = $gatewayData;

        // Processa o status do pagamento
        $statusLower = strtolower($status);

        if (in_array($statusLower, ['paid', 'approved', 'success', 'completed'])) {
            // Pagamento aprovado
            if ($order->status !== OrderStatus::Paid) {
                $order->status = OrderStatus::Paid;
                $order->paid_at = now();
                $order->save();

                Log::info('Expay Webhook: Pagamento aprovado', [
                    'order_id' => $order->id,
                    'transaction_id' => $transactionId,
                ]);

                // Envia notificação ao cliente
                Notification::route('mail', $order->customer_email)
                    ->notify(new OrderStatusChangedNotification($order));

                // Envia o pedido para o provedor
                SendOrderToProviderJob::dispatch($order);
            }
        } elseif (in_array($statusLower, ['cancelled', 'canceled', 'failed', 'expired'])) {
            // Pagamento cancelado/expirado
            if ($order->status === OrderStatus::AwaitingPayment) {
                $order->status = OrderStatus::Cancelled;
                $order->cancelled_at = now();
                $order->save();

                Log::info('Expay Webhook: Pagamento cancelado/expirado', [
                    'order_id' => $order->id,
                    'transaction_id' => $transactionId,
                    'status' => $status,
                ]);
            }
        } else {
            // Status pendente ou desconhecido - apenas atualiza os dados
            $order->save();

            Log::info('Expay Webhook: Status pendente ou desconhecido', [
                'order_id' => $order->id,
                'transaction_id' => $transactionId,
                'status' => $status,
            ]);
        }

        return response()->json(['message' => 'Webhook processado com sucesso'], 200);
    }
}
