<?php

namespace App\Models;

use App\Enums\PaymentGatewayType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentGateway extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'description',
        'credentials',
        'settings',
        'is_active',
        'is_pix_enabled',
        'is_credit_card_enabled',
        'is_boleto_enabled',
        'priority',
    ];

    protected $casts = [
        'credentials' => 'array',
        'settings' => 'array',
        'is_active' => 'boolean',
        'is_pix_enabled' => 'boolean',
        'is_credit_card_enabled' => 'boolean',
        'is_boleto_enabled' => 'boolean',
        'type' => PaymentGatewayType::class,
    ];

    /**
     * Obtém o gateway ativo para PIX
     */
    public static function getActivePixGateway(): ?self
    {
        return self::where('is_active', true)
            ->where('is_pix_enabled', true)
            ->orderBy('priority', 'desc')
            ->first();
    }

    /**
     * Obtém todos os gateways ativos ordenados por prioridade
     */
    public static function getActiveGateways(): \Illuminate\Database\Eloquent\Collection
    {
        return self::where('is_active', true)
            ->orderBy('priority', 'desc')
            ->get();
    }

    /**
     * Verifica se o gateway suporta um tipo de pagamento
     */
    public function supportsPaymentMethod(string $method): bool
    {
        return match ($method) {
            'pix' => $this->is_pix_enabled,
            'credit_card' => $this->is_credit_card_enabled,
            'boleto' => $this->is_boleto_enabled,
            default => false,
        };
    }

    /**
     * Obtém uma credencial específica
     */
    public function getCredential(string $key, $default = null)
    {
        return $this->credentials[$key] ?? $default;
    }

    /**
     * Obtém uma configuração específica
     */
    public function getSetting(string $key, $default = null)
    {
        return $this->settings[$key] ?? $default;
    }
}
