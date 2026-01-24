<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCreditBalance extends Model
{
    protected $fillable = [
        'user_id',
        'likes',
        'views',
        'comments',
    ];

    protected function casts(): array
    {
        return [
            'likes' => 'integer',
            'views' => 'integer',
            'comments' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
