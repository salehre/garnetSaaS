<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrencyPrice extends Model
{
    use HasFactory;

    protected $fillable = ['currency_id', 'price', 'fetched_at'];

    protected $casts = [
        'fetched_at' => 'datetime',
        'price' => 'decimal:2',
    ];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
