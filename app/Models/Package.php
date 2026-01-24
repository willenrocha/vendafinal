<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    protected $fillable = [
        'name',
        'is_active',
        'is_featured',
        'badge_text',

        'display_min',
        'display_max',
        'display_unit',

        'original_price',
        'price',

        'cta_label',
        'cta_href',

        'sort_order_mobile',
        'sort_order_desktop',

        'primary_service_id',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'original_price' => 'decimal:2',
            'price' => 'decimal:2',
        ];
    }

    public function primaryService(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'primary_service_id');
    }

    public function bonusItems(): HasMany
    {
        return $this->hasMany(PackageBonusItem::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
