<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Order $order,
        public readonly OrderStatus|string $previousStatus,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $order = $this->order->loadMissing('package');

        $prevLabel = $this->previousStatus instanceof OrderStatus
            ? $this->previousStatus->label()
            : (string) $this->previousStatus;

        $currentLabel = $order->status instanceof OrderStatus
            ? $order->status->label()
            : (string) $order->status;

        $code = (string) ($order->public_code ?? '');
        $codeLabel = $code !== '' ? $code : 'seu pedido';

        return (new MailMessage)
            ->subject('Atualização do pedido ' . $codeLabel)
            ->greeting('Olá, ' . $order->customer_name . '!')
            ->line('Seu pedido teve o status atualizado.')
            ->line('Antes: ' . $prevLabel)
            ->line('Agora: ' . $currentLabel)
            ->line('Pacote: ' . (($order->package?->name) ?? '—'))
            ->line('Instagram: @' . $order->instagram_username);
    }
}
