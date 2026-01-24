<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provider extends Model
{
    protected $fillable = [
        'name',
        'api_url',
        'api_key',
        'is_active',
        'balance',
        'currency',
        'balance_synced_at',
        'last_error',
        'last_error_at',
    ];

    protected function casts(): array
    {
        return [
            'api_key' => 'encrypted',
            'is_active' => 'boolean',
            'balance' => 'decimal:8',
            'balance_synced_at' => 'datetime',
            'last_error_at' => 'datetime',
        ];
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
