<?php

namespace App\Filament\Resources\InstagramProfiles;

use App\Filament\Resources\InstagramProfiles\Pages\CreateInstagramProfile;
use App\Filament\Resources\InstagramProfiles\Pages\EditInstagramProfile;
use App\Filament\Resources\InstagramProfiles\Pages\ListInstagramProfiles;
use App\Filament\Resources\InstagramProfiles\Pages\ViewInstagramProfile;
use App\Filament\Resources\InstagramProfiles\Schemas\InstagramProfileForm;
use App\Filament\Resources\InstagramProfiles\Schemas\InstagramProfileInfolist;
use App\Filament\Resources\InstagramProfiles\Tables\InstagramProfilesTable;
use App\Models\InstagramProfile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InstagramProfileResource extends Resource
{
    protected static ?string $model = InstagramProfile::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAtSymbol;

    protected static string|\UnitEnum|null $navigationGroup = 'Sistema';

    protected static ?int $navigationSort = 15;

    protected static ?string $recordTitleAttribute = 'username';

    public static function getNavigationLabel(): string
    {
        return 'Perfis Instagram';
    }

    public static function getModelLabel(): string
    {
        return 'Perfil Instagram';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Perfis Instagram';
    }

    public static function form(Schema $schema): Schema
    {
        return InstagramProfileForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InstagramProfileInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InstagramProfilesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInstagramProfiles::route('/'),
            'create' => CreateInstagramProfile::route('/create'),
            'view' => ViewInstagramProfile::route('/{record}'),
            'edit' => EditInstagramProfile::route('/{record}/edit'),
        ];
    }
}
