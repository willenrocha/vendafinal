<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderAwaitingPaymentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Order $order,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $order = $this->order->loadMissing('package');

        $statusLabel = $order->status instanceof OrderStatus
            ? $order->status->label()
            : (string) $order->status;

        $code = (string) ($order->public_code ?? '');
        $codePrefix = $code !== '' ? ($code . ' — ') : '';

        $mail = (new MailMessage)
            ->subject('Pedido ' . $codePrefix . $statusLabel)
            ->greeting('Olá, ' . $order->customer_name . '!')
            ->line('Seu pedido foi registrado e está com status: ' . $statusLabel . '.')
            ->line('Pacote: ' . (($order->package?->name) ?? '—'))
            ->line('Instagram: @' . $order->instagram_username)
            ->line('Total: R$ ' . number_format((float) $order->amount, 2, ',', '.'));

        if (is_string($order->pix_brcode) && $order->pix_brcode !== '') {
            $mail->line('Pix copia e cola:')->line($order->pix_brcode);
        }

        return $mail->line('Assim que o pagamento for confirmado, vamos te avisar por e-mail.');
    }
}
