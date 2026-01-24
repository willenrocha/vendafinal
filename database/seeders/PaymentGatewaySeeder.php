<?php

namespace Database\Seeders;

use App\Enums\PaymentGatewayType;
use App\Models\PaymentGateway;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Gateway Expay Brasil (Ativo por padrão)
        PaymentGateway::create([
            'name' => 'Expay Brasil',
            'type' => PaymentGatewayType::EXPAY,
            'description' => 'Gateway de pagamento Expay Brasil para PIX',
            'credentials' => [
                'merchant_key' => env('EXPAY_MERCHANT_KEY', '$2y$12$Cu4IJ99VvtJskWRVPvRRPuMvDktbg7omL5RfDl2v37nYYgph/7f6C'),
            ],
            'settings' => [
                'api_url' => env('EXPAY_API_URL', 'https://expaybrasil.com'),
                'webhook_url' => env('APP_URL') . '/api/webhooks/expay',
                'timeout' => 30,
            ],
            'is_active' => true,
            'is_pix_enabled' => true,
            'is_credit_card_enabled' => false,
            'is_boleto_enabled' => false,
            'priority' => 100,
        ]);

        // Gateway Mercado Pago (Desativado)
        PaymentGateway::create([
            'name' => 'Mercado Pago',
            'type' => PaymentGatewayType::MERCADO_PAGO,
            'description' => 'Gateway de pagamento Mercado Pago',
            'credentials' => [
                'access_token' => env('MERCADOPAGO_ACCESS_TOKEN', ''),
                'public_key' => env('MERCADOPAGO_PUBLIC_KEY', ''),
            ],
            'settings' => [
                'api_url' => 'https://api.mercadopago.com',
                'webhook_url' => env('APP_URL') . '/api/webhooks/mercadopago',
            ],
            'is_active' => false,
            'is_pix_enabled' => true,
            'is_credit_card_enabled' => true,
            'is_boleto_enabled' => true,
            'priority' => 90,
        ]);

        // Gateway Asaas (Desativado)
        PaymentGateway::create([
            'name' => 'Asaas',
            'type' => PaymentGatewayType::ASAAS,
            'description' => 'Gateway de pagamento Asaas',
            'credentials' => [
                'api_key' => env('ASAAS_API_KEY', ''),
            ],
            'settings' => [
                'api_url' => 'https://www.asaas.com/api/v3',
                'webhook_url' => env('APP_URL') . '/api/webhooks/asaas',
            ],
            'is_active' => false,
            'is_pix_enabled' => true,
            'is_credit_card_enabled' => true,
            'is_boleto_enabled' => true,
            'priority' => 80,
        ]);
    }
}
