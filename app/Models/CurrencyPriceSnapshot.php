<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrencyPriceSnapshot extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency_id',
        'interval_type',
        'bucket_date',
        'bucket_range',
        'entry_price',
        'exit_price',
        'min_price',
        'max_price',
        'avg_price',
        'snapshotted_at',
    ];

    protected $casts = [
        'bucket_date' => 'date',
        'snapshotted_at' => 'datetime',
        'entry_price' => 'decimal:2',
        'exit_price' => 'decimal:2',
        'min_price' => 'decimal:2',
        'max_price' => 'decimal:2',
        'avg_price' => 'decimal:2',
    ];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}