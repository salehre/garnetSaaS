<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrencyDailyStat extends Model
{
    use HasFactory;

    protected $fillable = ['currency_id', 'date', 'open', 'close', 'min', 'max', 'avg'];

    protected $casts = [
        'date' => 'date',
        'open' => 'decimal:2',
        'close' => 'decimal:2',
        'min' => 'decimal:2',
        'max' => 'decimal:2',
        'avg' => 'decimal:2',
    ];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
