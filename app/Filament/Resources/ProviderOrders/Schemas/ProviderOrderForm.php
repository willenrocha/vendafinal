<?php

namespace App\Filament\Resources\ProviderOrders\Schemas;

use App\Enums\ProviderOrderStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProviderOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('public_id')
                    ->required(),
                TextInput::make('public_code')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('order_id')
                    ->relationship('order', 'id'),
                Select::make('package_id')
                    ->relationship('package', 'name'),
                Select::make('service_id')
                    ->relationship('service', 'name')
                    ->required(),
                Select::make('instagram_profile_id')
                    ->relationship('instagramProfile', 'id')
                    ->required(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric(),
                TextInput::make('provider_order_id'),
                Select::make('provider_order_status')
                    ->options(ProviderOrderStatus::class),
                TextInput::make('provider_charge')
                    ->numeric(),
                TextInput::make('provider_start_count')
                    ->numeric(),
                TextInput::make('provider_remains')
                    ->numeric(),
                TextInput::make('provider_currency'),
                DateTimePicker::make('provider_order_sent_at'),
                DateTimePicker::make('provider_last_check_at'),
            ]);
    }
}
