<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ProviderOrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ProviderOrder extends Model
{
    protected $fillable = [
        'public_id',
        'public_code',
        'user_id',
        'order_id',
        'package_id',
        'service_id',
        'instagram_profile_id',
        'quantity',
        'provider_order_id',
        'provider_order_status',
        'provider_charge',
        'provider_start_count',
        'provider_remains',
        'provider_currency',
        'provider_order_sent_at',
        'provider_last_check_at',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'provider_order_status' => ProviderOrderStatus::class,
        'provider_charge' => 'decimal:5',
        'provider_start_count' => 'integer',
        'provider_remains' => 'integer',
        'provider_order_sent_at' => 'datetime',
        'provider_last_check_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $providerOrder): void {
            if (! is_string($providerOrder->public_id) || $providerOrder->public_id === '') {
                $providerOrder->public_id = (string) Str::uuid();
            }

            if (! is_string($providerOrder->public_code) || $providerOrder->public_code === '') {
                $providerOrder->public_code = self::generatePublicCode();

                // Evita colisões
                while (self::query()->where('public_code', $providerOrder->public_code)->exists()) {
                    $providerOrder->public_code = self::generatePublicCode();
                }
            }
        });
    }

    private static function generatePublicCode(): string
    {
        // Código para Provider Order: PO-XXXXXXXXXX
        $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $len = 10;

        $code = 'PO-';
        for ($i = 0; $i < $len; $i++) {
            $code .= $alphabet[random_int(0, strlen($alphabet) - 1)];
        }

        return $code;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function instagramProfile(): BelongsTo
    {
        return $this->belongsTo(InstagramProfile::class);
    }
}
