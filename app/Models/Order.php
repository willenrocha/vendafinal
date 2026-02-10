<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'public_id',
        'public_code',
        'package_id',
        'user_id',
        'instagram_profile_id',
        'status',
        'is_credit_redemption',
        'customer_name',
        'customer_email',
        'customer_phone',
        'instagram_username',
        'instagram_profile',
        'package_snapshot',
        'amount',
        'currency',
        'pix_brcode',
        'pix_generated_at',
        'payment_gateway_transaction_id',
        'payment_gateway_data',
        'paid_at',
        'cancelled_at',
        'email_sent_at',
        'contacted_at',
        'contact_notes',
        'contacted_by',
        'provider_order_id',
        'provider_order_sent_at',
        'provider_order_status',
        'provider_charge',
        'provider_start_count',
        'provider_remains',
        'provider_currency',
        'provider_last_check_at',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'is_credit_redemption' => 'boolean',
        'instagram_profile' => 'array',
        'package_snapshot' => 'array',
        'payment_gateway_data' => 'array',
        'amount' => 'decimal:2',
        'pix_generated_at' => 'datetime',
        'paid_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'email_sent_at' => 'datetime',
        'contacted_at' => 'datetime',
        'provider_order_sent_at' => 'datetime',
        'provider_order_status' => \App\Enums\ProviderOrderStatus::class,
        'provider_charge' => 'decimal:5',
        'provider_last_check_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $order): void {
            if (! is_string($order->public_id) || $order->public_id === '') {
                $order->public_id = (string) Str::uuid();
            }

            if (! is_string($order->public_code) || $order->public_code === '') {
                $order->public_code = self::generatePublicCode();

                // Evita colisões (bem improvável, mas garantimos pelo unique).
                while (self::query()->where('public_code', $order->public_code)->exists()) {
                    $order->public_code = self::generatePublicCode();
                }
            }
        });
    }

    private static function generatePublicCode(): string
    {
        // Código curto e “bonito” (sem 0/O e 1/I) para o cliente.
        $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $len = 10;

        $code = 'P-';
        for ($i = 0; $i < $len; $i++) {
            $code .= $alphabet[random_int(0, strlen($alphabet) - 1)];
        }

        return $code;
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function instagramProfile(): BelongsTo
    {
        return $this->belongsTo(InstagramProfile::class);
    }

    public function providerOrders(): HasMany
    {
        return $this->hasMany(ProviderOrder::class);
    }

    protected function customerEmailLower(): Attribute
    {
        return Attribute::make(
            get: fn () => strtolower((string) $this->customer_email),
        );
    }

    /**
     * Busca ou cria pedido pendente para evitar duplicação.
     * Agora usa instagram_profile_id ao invés de instagram_username.
     */
    public static function findOrCreatePendingOrder(
        string $customerEmail,
        int $packageId,
        string $customerName,
        string $amount,
        ?int $instagramProfileId = null,
        ?string $instagramUsername = null
    ): array {
        $query = static::query()
            ->where('customer_email', strtolower(trim($customerEmail)))
            ->where('package_id', $packageId)
            ->where('status', OrderStatus::AwaitingPayment)
            ->where('created_at', '>=', now()->subHours(24));

        // Prioriza busca por instagram_profile_id se fornecido
        if ($instagramProfileId !== null) {
            $query->where('instagram_profile_id', $instagramProfileId);
        } elseif ($instagramUsername !== null) {
            // Fallback para username (dados legados)
            $query->where('instagram_username', strtolower(trim($instagramUsername)));
        }

        $existingOrder = $query->orderByDesc('created_at')->first();

        if ($existingOrder) {
            return ['order' => $existingOrder, 'wasNew' => false];
        }

        $newOrder = static::create([
            'package_id' => $packageId,
            'instagram_profile_id' => $instagramProfileId,
            'instagram_username' => $instagramUsername,
            'customer_name' => $customerName,
            'customer_email' => strtolower(trim($customerEmail)),
            'amount' => $amount,
            'currency' => 'BRL',
            'status' => OrderStatus::AwaitingPayment,
        ]);

        return ['order' => $newOrder, 'wasNew' => true];
    }
}
