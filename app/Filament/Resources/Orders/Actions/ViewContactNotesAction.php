<?php

namespace App\Filament\Resources\Orders\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Support\Icons\Heroicon;

class ViewContactNotesAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'view_contact_notes';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Ver Notas de Contato')
            ->icon(Heroicon::OutlinedEye)
            ->color('info')
            ->modalHeading('Notas de Contato')
            ->modalContent(fn ($record) => view('filament.resources.orders.contact-notes', [
                'record' => $record,
            ]))
            ->modalCancelActionLabel('Fechar')
            ->modalSubmitAction(false)
            ->visible(fn ($record) => $record->contacted_at !== null);
    }
}
