<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    protected $fillable = [
        'provider_id',
        'provider_service_id',

        'name',
        'social_network',
        'credit_type',
        'is_active',

        'provider_name',
        'provider_type',
        'provider_category',
        'provider_rate',
        'provider_min',
        'provider_max',
        'provider_refill',
        'provider_cancel',

        'provider_synced_at',
        'last_error',
        'last_error_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'provider_rate' => 'decimal:8',
            'provider_refill' => 'boolean',
            'provider_cancel' => 'boolean',
            'provider_synced_at' => 'datetime',
            'last_error_at' => 'datetime',
        ];
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}
