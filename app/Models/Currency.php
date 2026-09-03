<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'label', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function prices(): HasMany
    {
        return $this->hasMany(CurrencyPrice::class);
    }

    /**
     * The most recent price record for this currency (single row, no N+1 loop needed).
     */
    public function latestPrice(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(CurrencyPrice::class)->latestOfMany('fetched_at');
    }

    public function dailyStats(): HasMany
    {
        return $this->hasMany(CurrencyDailyStat::class);
    }

    public function snapshots(): HasMany
    {
        return $this->hasMany(CurrencyPriceSnapshot::class);
    }

    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'customer_currency');
    }
}
