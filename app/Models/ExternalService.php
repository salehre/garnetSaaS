<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ExternalService extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'match_key', 'label', 'price', 'is_active'];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Markup applied on top of the raw api.ir cost when charging the customer.
     * `price` stays the imported/raw cost from the Excel sheet; this multiplier
     * is applied only at charge-time, so changing it never touches `price`.
     */
    public const MARKUP_MULTIPLIER = 1.5;

    /**
     * The amount actually deducted from a customer's wallet per call.
     */
    public function chargePrice(): float
    {
        return round(((float) $this->price) * self::MARKUP_MULTIPLIER, 2);
    }

    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class);
    }
}