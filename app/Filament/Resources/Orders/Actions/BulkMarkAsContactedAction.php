<?php

namespace App\Filament\Resources\Orders\Actions;

use Filament\Actions\BulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class BulkMarkAsContactedAction extends BulkAction
{
    public static function getDefaultName(): ?string
    {
        return 'bulk_mark_as_contacted';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Marcar como Contatados')
            ->icon(Heroicon::OutlinedCheckCircle)
            ->color('success')
            ->form([
                Textarea::make('contact_notes')
                    ->label('Notas de Contato')
                    ->placeholder('Adicione observações gerais sobre os contatos realizados...')
                    ->rows(3)
                    ->required(),
            ])
            ->action(function (Collection $records, array $data): void {
                $records->each(function ($record) use ($data) {
                    if ($record->contacted_at === null) {
                        $record->update([
                            'contacted_at' => now(),
                            'contacted_by' => Auth::user()->name ?? Auth::user()->email,
                            'contact_notes' => $data['contact_notes'],
                        ]);
                    }
                });
            })
            ->requiresConfirmation()
            ->modalHeading('Marcar Pedidos como Contatados')
            ->modalDescription('Todos os pedidos selecionados serão marcados como contatados com as mesmas notas.')
            ->modalSubmitActionLabel('Marcar Todos')
            ->deselectRecordsAfterCompletion()
            ->successNotificationTitle('Pedidos marcados como contatados');
    }
}
