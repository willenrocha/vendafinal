<?php

namespace App\Filament\Resources\PaymentGateways\Schemas;

use App\Enums\PaymentGatewayType;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PaymentGatewayForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informações Gerais')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome do Gateway')
                            ->required()
                            ->maxLength(255),

                        Select::make('type')
                            ->label('Tipo de Gateway')
                            ->options(PaymentGatewayType::class)
                            ->required()
                            ->native(false),

                        Textarea::make('description')
                            ->label('Descrição')
                            ->rows(3)
                            ->maxLength(500),

                        TextInput::make('priority')
                            ->label('Prioridade')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->helperText('Gateways com maior prioridade serão usados primeiro'),
                    ])
                    ->columns(2),

                Section::make('Métodos de Pagamento')
                    ->schema([
                        Toggle::make('is_pix_enabled')
                            ->label('PIX Habilitado')
                            ->default(true)
                            ->inline(false),

                        Toggle::make('is_credit_card_enabled')
                            ->label('Cartão de Crédito Habilitado')
                            ->default(false)
                            ->inline(false),

                        Toggle::make('is_boleto_enabled')
                            ->label('Boleto Habilitado')
                            ->default(false)
                            ->inline(false),

                        Toggle::make('is_active')
                            ->label('Gateway Ativo')
                            ->default(false)
                            ->inline(false)
                            ->helperText('Apenas gateways ativos serão utilizados'),
                    ])
                    ->columns(4),

                Section::make('Credenciais')
                    ->schema([
                        KeyValue::make('credentials')
                            ->label('Credenciais da API')
                            ->keyLabel('Chave')
                            ->valueLabel('Valor')
                            ->addActionLabel('Adicionar Credencial')
                            ->required()
                            ->helperText('Ex: api_key, secret_key, merchant_id, etc. Os valores serão criptografados.'),
                    ]),

                Section::make('Configurações')
                    ->schema([
                        KeyValue::make('settings')
                            ->label('Configurações Adicionais')
                            ->keyLabel('Chave')
                            ->valueLabel('Valor')
                            ->addActionLabel('Adicionar Configuração')
                            ->helperText('Ex: api_url, webhook_url, timeout, etc.'),
                    ]),
            ]);
    }
}
