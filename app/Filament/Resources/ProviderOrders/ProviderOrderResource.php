<?php

namespace App\Filament\Resources\ProviderOrders;

use App\Filament\Resources\ProviderOrders\Pages\CreateProviderOrder;
use App\Filament\Resources\ProviderOrders\Pages\EditProviderOrder;
use App\Filament\Resources\ProviderOrders\Pages\ListProviderOrders;
use App\Filament\Resources\ProviderOrders\Schemas\ProviderOrderForm;
use App\Filament\Resources\ProviderOrders\Tables\ProviderOrdersTable;
use App\Models\ProviderOrder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProviderOrderResource extends Resource
{
    protected static ?string $model = ProviderOrder::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;

    protected static ?string $recordTitleAttribute = 'public_code';

    protected static ?string $navigationLabel = 'Pedidos ao Provedor';

    protected static ?string $modelLabel = 'Pedido ao Provedor';

    protected static ?string $pluralModelLabel = 'Pedidos ao Provedor';

    protected static string|\UnitEnum|null $navigationGroup = 'Vendas';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return ProviderOrderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProviderOrdersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProviderOrders::route('/'),
        ];
    }
}
