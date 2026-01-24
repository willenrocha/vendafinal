<?php

namespace App\Filament\Resources\Credits;

use App\Filament\Resources\Credits\Pages\CreateUserCreditBalance;
use App\Filament\Resources\Credits\Pages\EditUserCreditBalance;
use App\Filament\Resources\Credits\Pages\ListUserCreditBalances;
use App\Filament\Resources\Credits\Pages\ViewUserCreditBalance;
use App\Filament\Resources\Credits\Schemas\UserCreditBalanceForm;
use App\Filament\Resources\Credits\Schemas\UserCreditBalanceInfolist;
use App\Filament\Resources\Credits\Tables\UserCreditBalancesTable;
use App\Models\UserCreditBalance;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserCreditBalanceResource extends Resource
{
    protected static ?string $model = UserCreditBalance::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    protected static string|\UnitEnum|null $navigationGroup = 'Sistema';

    protected static ?int $navigationSort = 20;

    protected static ?string $recordTitleAttribute = 'id';

    public static function getNavigationLabel(): string
    {
        return 'Créditos';
    }

    public static function getModelLabel(): string
    {
        return 'Crédito';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Créditos';
    }

    public static function form(Schema $schema): Schema
    {
        return UserCreditBalanceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserCreditBalanceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserCreditBalancesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUserCreditBalances::route('/'),
            'create' => CreateUserCreditBalance::route('/create'),
            'view' => ViewUserCreditBalance::route('/{record}'),
        ];
    }
}
