<?php

namespace App\Services\Payment;

use App\Helpers\CpfGenerator;
use App\Models\Order;
use App\Models\PaymentGateway;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ExpayService
{
    protected Client $client;
    protected PaymentGateway $gateway;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 30,
            'verify' => true,
        ]);

        // Busca o gateway Expay ativo
        $gateway = PaymentGateway::where('type', 'expay')
            ->where('is_active', true)
            ->first();

        if (!$gateway) {
            throw new \Exception('Gateway Expay não está configurado ou ativo.');
        }

        $this->gateway = $gateway;
    }

    /**
     * Cria uma cobrança PIX via Expay
     */
    public function createPixCharge(Order $order): array
    {
        $merchantKey = $this->gateway->getCredential('merchant_key');
        $apiUrl = $this->gateway->getSetting('api_url', 'https://expaybrasil.com');

        if (!$merchantKey) {
            throw new \Exception('Merchant Key não configurada para Expay.');
        }

        // Gera CPF válido automaticamente (não armazenamos, apenas enviamos)
        $cpf = CpfGenerator::generate();

        // Prepara os dados da invoice
        $invoiceData = [
            'invoice_id' => (string) $order->id,
            'invoice_description' => 'Pedido #' . $order->id . ' - ' . ($order->package?->name ?? 'Produto'),
            'total' => number_format((float) $order->amount, 2, '.', ''),
            'devedor' => $order->customer_name,
            'email' => $order->customer_email,
            'cpf_cnpj' => $cpf,
            'notification_url' => route('webhooks.expay'),
            'telefone' => $this->formatPhone($order->customer_phone ?? ''),
            'items' => [
                [
                    'name' => $order->package?->name ?? 'Produto',
                    'price' => number_format((float) $order->amount, 2, '.', ''),
                    'description' => $order->package?->description ?? 'Pedido de produto',
                    'qty' => '1',
                ],
            ],
        ];

        try {
            $response = $this->client->request('POST', $apiUrl . '/en/purchase/link', [
                'form_params' => [
                    'merchant_key' => $merchantKey,
                    'currency_code' => 'BRL',
                    'invoice' => json_encode($invoiceData),
                ],
                'headers' => [
                    'accept' => 'application/json',
                    'content-type' => 'application/x-www-form-urlencoded',
                ],
            ]);

            $body = $response->getBody()->getContents();

            if (empty($body)) {
                Log::error('Expay: Resposta vazia da API', [
                    'status_code' => $response->getStatusCode(),
                    'headers' => $response->getHeaders(),
                ]);
                throw new \Exception('A Expay retornou uma resposta vazia.');
            }

            Log::info('Expay: Resposta recebida', [
                'status_code' => $response->getStatusCode(),
                'body' => $body,
            ]);

            $data = json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Expay: Erro ao decodificar JSON', [
                    'error' => json_last_error_msg(),
                    'body' => $body,
                ]);
                throw new \Exception('Erro ao processar resposta da Expay.');
            }

            if (!isset($data['pix_request'])) {
                Log::error('Expay: Resposta inválida', ['response' => $data]);
                throw new \Exception('Resposta inválida da Expay.');
            }

            $pixRequest = $data['pix_request'];

            if (!($pixRequest['result'] ?? false)) {
                $errorMessage = $pixRequest['error_message'] ?? 'Erro desconhecido ao gerar PIX.';
                Log::error('Expay: Erro ao gerar PIX', ['error' => $errorMessage, 'response' => $data]);
                throw new \Exception($errorMessage);
            }

            // Atualiza o pedido com as informações do PIX
            $order->update([
                'pix_brcode' => $pixRequest['pix_code']['emv'] ?? null,
                'pix_generated_at' => now(),
                'payment_gateway_transaction_id' => (string) ($pixRequest['transaction_id'] ?? ''),
                'payment_gateway_data' => $pixRequest,
            ]);

            Log::info('Expay: PIX gerado com sucesso', [
                'order_id' => $order->id,
                'transaction_id' => $pixRequest['transaction_id'] ?? null,
            ]);

            return [
                'success' => true,
                'brcode' => $pixRequest['pix_code']['emv'] ?? '',
                'qrcode_base64' => $pixRequest['pix_code']['qrcode_base64'] ?? null,
                'transaction_id' => $pixRequest['transaction_id'] ?? null,
                'expire_date' => $pixRequest['expire_date'] ?? null,
                'value' => $pixRequest['value'] ?? $order->amount,
            ];
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $errorMessage = 'Erro ao conectar com Expay: ' . $e->getMessage();

            if ($e->hasResponse()) {
                $responseBody = $e->getResponse()->getBody()->getContents();
                Log::error('Expay: Erro na requisição', [
                    'error' => $errorMessage,
                    'response' => $responseBody,
                ]);
            } else {
                Log::error('Expay: Erro na requisição', ['error' => $errorMessage]);
            }

            throw new \Exception('Não foi possível gerar o PIX. Tente novamente.');
        } catch (\Exception $e) {
            Log::error('Expay: Erro inesperado', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }

    /**
     * Formata telefone para o padrão aceito pela Expay
     */
    protected function formatPhone(?string $phone): string
    {
        if (!$phone) {
            return '';
        }

        // Remove tudo que não for número
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Se tiver 11 dígitos, está OK
        if (strlen($phone) === 11) {
            return $phone;
        }

        // Se tiver 10, adiciona 9 na frente do número
        if (strlen($phone) === 10) {
            return substr($phone, 0, 2) . '9' . substr($phone, 2);
        }

        return $phone;
    }

    /**
     * Verifica o status de uma transação na Expay
     */
    public function checkTransactionStatus(string $transactionId): array
    {
        // TODO: Implementar quando a Expay fornecer endpoint de consulta
        // Por enquanto, o status será atualizado via webhook

        return [
            'status' => 'pending',
            'message' => 'Aguardando confirmação de pagamento.',
        ];
    }
}
