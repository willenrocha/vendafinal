<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerAccountCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Order $order,
        public readonly string $temporaryPassword,
        public readonly ?string $loginUrl = null,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $order = $this->order->loadMissing('package');

        $code = (string) ($order->public_code ?? '');
        $subjectSuffix = $code !== '' ? (' — ' . $code) : '';

        $loginUrl = $this->loginUrl;
        if (! is_string($loginUrl) || trim($loginUrl) === '') {
            $loginUrl = (string) config('services.client.app_url', '');
        }

        return (new MailMessage)
            ->subject('Acesso liberado' . $subjectSuffix)
            ->greeting('Olá, ' . $order->customer_name . '!')
            ->line('Pagamento confirmado. Seu acesso foi liberado.')
            ->line('Pacote: ' . (($order->package?->name) ?? '—'))
            ->line('E-mail de acesso: ' . $order->customer_email)
            ->line('Senha temporária: ' . $this->temporaryPassword)
            ->line('Recomendamos trocar a senha assim que o portal estiver disponível.')
            ->when($loginUrl !== '', fn (MailMessage $m) => $m->action('Acessar portal do cliente', $loginUrl))
            ->line('Se precisar de ajuda, responda este e-mail.');
    }
}
