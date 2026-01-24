<?php

namespace App\Filament\Resources\Orders\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class MarkAsContactedAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'mark_as_contacted';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Marcar como Contatado')
            ->icon(Heroicon::OutlinedCheckCircle)
            ->color('success')
            ->form([
                Textarea::make('contact_notes')
                    ->label('Notas de Contato')
                    ->placeholder('Adicione observações sobre o contato realizado...')
                    ->rows(3)
                    ->required(),
            ])
            ->action(function (array $data, $record): void {
                $record->update([
                    'contacted_at' => now(),
                    'contacted_by' => Auth::user()->name ?? Auth::user()->email,
                    'contact_notes' => $data['contact_notes'],
                ]);
            })
            ->requiresConfirmation()
            ->modalHeading('Marcar Pedido como Contatado')
            ->modalDescription('Registre as observações sobre o contato realizado com este cliente.')
            ->modalSubmitActionLabel('Salvar')
            ->successNotificationTitle('Pedido marcado como contatado')
            ->visible(fn ($record) => $record->contacted_at === null);
    }
}
