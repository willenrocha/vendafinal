<?php

namespace App\Filament\Resources\Orders\Actions;

use App\Enums\OrderStatus;
use App\Jobs\SendOrderToProviderJob;
use App\Jobs\SyncInstagramProfileJob;
use App\Models\Order;
use App\Notifications\CustomerAccountCreatedNotification;
use App\Notifications\OrderStatusChangedNotification;
use App\Services\Credits\UserCreditService;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class ConfirmPaymentAction
{
    public static function make(): Action
    {
        return Action::make('confirmPayment')
            ->label('Confirmar pagamento')
            ->icon('heroicon-o-check-circle')
            ->requiresConfirmation()
            ->color('success')
            ->visible(fn (Order $record): bool => (
                ($record->status?->value ?? (string) $record->status) === OrderStatus::AwaitingPayment->value
            ))
            ->action(function (Order $record): void {
                // Guard: evita processar pedido já pago
                if (($record->status?->value ?? (string) $record->status) === OrderStatus::Paid->value) {
                    return;
                }

                $previous = $record->status;

                $record->forceFill([
                    'status' => OrderStatus::Paid,
                    'paid_at' => now(),
                    'cancelled_at' => null,
                ])->save();

                // Cria usuário cliente somente após pagamento.
                $user = $record->user;
                if (! $user) {
                    $user = \App\Models\User::query()->where('email', $record->customer_email)->first();
                }

                $temporaryPassword = null;

                if ($user && (bool) ($user->is_admin ?? false)) {
                    // Segurança: nunca mexe em admin.
                    $user = null;
                }

                if (! $user) {
                    $temporaryPassword = Str::password(12);

                    $user = \App\Models\User::create([
                        'name' => $record->customer_name,
                        'email' => $record->customer_email,
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
                $record->forceFill([
                    'user_id' => $user->id,
                ])->save();

                if (is_string($temporaryPassword) && $temporaryPassword !== '') {
                    Notification::route('mail', (string) $record->customer_email)
                        ->notify(new CustomerAccountCreatedNotification(
                            order: $record,
                            temporaryPassword: $temporaryPassword,
                            loginUrl: (string) config('services.client.app_url', ''),
                        ));
                }

                // Adiciona créditos/bônus do pacote ao usuário
                if ($user && $record->package) {
                    $creditService = app(UserCreditService::class);
                    $creditService->addPackageBonus($user, $record->package);
                }

                // Dispara job para sincronizar perfil do Instagram e posts (processo pesado, roda em background)
                if ($record->instagramProfile) {
                    SyncInstagramProfileJob::dispatch($record->instagramProfile->id, postsLimit: 12);
                }

                // Dispara job para enviar pedido ao provedor (PerfectPanel)
                SendOrderToProviderJob::dispatch($record->id);

                Notification::route('mail', (string) $record->customer_email)
                    ->notify(new OrderStatusChangedNotification($record, $previous));
            });
    }
}
