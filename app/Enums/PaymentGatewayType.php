<?php

namespace App\Enums;

enum PaymentGatewayType: string
{
    case EXPAY = 'expay';
    case MERCADO_PAGO = 'mercado_pago';
    case ASAAS = 'asaas';
    case PAGSEGURO = 'pagseguro';

    public function label(): string
    {
        return match ($this) {
            self::EXPAY => 'Expay Brasil',
            self::MERCADO_PAGO => 'Mercado Pago',
            self::ASAAS => 'Asaas',
            self::PAGSEGURO => 'PagSeguro',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::EXPAY => 'Gateway de pagamento Expay Brasil',
            self::MERCADO_PAGO => 'Gateway de pagamento Mercado Pago',
            self::ASAAS => 'Gateway de pagamento Asaas',
            self::PAGSEGURO => 'Gateway de pagamento PagSeguro',
        };
    }
}
