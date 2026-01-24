<?php

namespace App\Filament\Resources\Packages\Pages;

use App\Filament\Resources\Packages\PackageResource;
use App\Filament\Resources\Packages\Tables\PackagesTable;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;
use Livewire\Attributes\Url;

class ListPackages extends ListRecords
{
    protected static string $resource = PackageResource::class;

    #[Url(as: 'order')]
    public string $orderMode = 'mobile';

    protected function normalizeOrderMode(): void
    {
        if (! in_array($this->orderMode, ['mobile', 'desktop'], true)) {
            $this->orderMode = 'mobile';
        }
    }

    protected function getActiveOrderColumn(): string
    {
        $this->normalizeOrderMode();

        return $this->orderMode === 'desktop'
            ? 'sort_order_desktop'
            : 'sort_order_mobile';
    }

    public function table(Table $table): Table
    {
        $reorderColumn = $this->getActiveOrderColumn();
        $modeLabel = $this->orderMode === 'desktop' ? 'Desktop' : 'Mobile';

        return PackagesTable::configure($table)
            ->defaultSort($reorderColumn)
            ->reorderable($reorderColumn)
            ->reorderRecordsTriggerAction(function (Action $action, bool $isReordering) use ($modeLabel): Action {
                return $action->label($isReordering ? "Concluir ({$modeLabel})" : "Reordenar ({$modeLabel})");
            })
            ->paginated(false);
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),

            Action::make('orderMobile')
                ->label('Ordem: Mobile')
                ->color(fn (): string => $this->orderMode === 'mobile' ? 'primary' : 'gray')
                ->action(function (): void {
                    $this->orderMode = 'mobile';
                    $this->isTableReordering = false;
                }),

            Action::make('orderDesktop')
                ->label('Ordem: Desktop')
                ->color(fn (): string => $this->orderMode === 'desktop' ? 'primary' : 'gray')
                ->action(function (): void {
                    $this->orderMode = 'desktop';
                    $this->isTableReordering = false;
                }),
        ];
    }
}
