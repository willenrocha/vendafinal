<?php

namespace App\Filament\Resources\Credits\Actions;

use App\Models\UserCreditBalance;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class RemoveCreditsAction
{
    public static function make(): Action
    {
        return Action::make('removeCredits')
            ->label('Remover créditos')
            ->icon('heroicon-o-minus-circle')
            ->color('danger')
            ->form(fn (UserCreditBalance $record) => [
                Select::make('credit_type')
                    ->label('Tipo de crédito')
                    ->options([
                        'likes' => 'Curtidas',
                        'views' => 'Visualizações',
                        'comments' => 'Comentários',
                    ])
                    ->required()
                    ->native(false)
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) use ($record) {
                        if ($state) {
                            $set('current_balance', $record->{$state} ?? 0);
                        }
                    }),

                TextInput::make('current_balance')
                    ->label('Saldo atual')
                    ->disabled()
                    ->dehydrated(false)
                    ->default(0)
                    ->numeric(),

                TextInput::make('amount')
                    ->label('Quantidade a remover')
                    ->numeric()
                    ->minValue(1)
                    ->required()
                    ->helperText('Digite a quantidade a ser removida do saldo atual.'),
            ])
            ->action(function (UserCreditBalance $record, array $data): void {
                $type = $data['credit_type'];
                $amount = (int) $data['amount'];
                $currentBalance = $record->{$type} ?? 0;

                if ($amount > $currentBalance) {
                    Notification::make()
                        ->title('Erro')
                        ->body('Quantidade a remover é maior que o saldo disponível.')
                        ->danger()
                        ->send();

                    return;
                }

                $record->decrement($type, $amount);

                $typeLabel = match ($type) {
                    'likes' => 'curtidas',
                    'views' => 'visualizações',
                    'comments' => 'comentários',
                    default => 'créditos',
                };

                Notification::make()
                    ->title('Créditos removidos')
                    ->body(sprintf(
                        '%s %s removidas do usuário %s',
                        number_format($amount, 0, ',', '.'),
                        $typeLabel,
                        $record->user->email
                    ))
                    ->success()
                    ->send();
            });
    }
}
