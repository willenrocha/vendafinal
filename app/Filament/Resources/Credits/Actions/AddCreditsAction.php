<?php

namespace App\Filament\Resources\Credits\Actions;

use App\Models\UserCreditBalance;
use App\Services\Credits\UserCreditService;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class AddCreditsAction
{
    public static function make(): Action
    {
        return Action::make('addCredits')
            ->label('Adicionar créditos')
            ->icon('heroicon-o-plus-circle')
            ->color('success')
            ->form([
                Select::make('credit_type')
                    ->label('Tipo de crédito')
                    ->options([
                        'likes' => 'Curtidas',
                        'views' => 'Visualizações',
                        'comments' => 'Comentários',
                    ])
                    ->required()
                    ->native(false),

                TextInput::make('amount')
                    ->label('Quantidade')
                    ->numeric()
                    ->minValue(1)
                    ->required()
                    ->helperText('Digite a quantidade a ser adicionada ao saldo atual.'),
            ])
            ->action(function (UserCreditBalance $record, array $data): void {
                $creditService = app(UserCreditService::class);

                $creditService->add(
                    user: $record->user,
                    type: $data['credit_type'],
                    amount: (int) $data['amount']
                );

                $typeLabel = match ($data['credit_type']) {
                    'likes' => 'curtidas',
                    'views' => 'visualizações',
                    'comments' => 'comentários',
                    default => 'créditos',
                };

                Notification::make()
                    ->title('Créditos adicionados')
                    ->body(sprintf(
                        '%s %s adicionadas ao usuário %s',
                        number_format((int) $data['amount'], 0, ',', '.'),
                        $typeLabel,
                        $record->user->email
                    ))
                    ->success()
                    ->send();
            });
    }
}
