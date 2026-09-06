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

    public const MARKUP_MULTIPLIER = 1.5;

    public function chargePrice(): float
    {
        return round(((float) $this->price) * self::MARKUP_MULTIPLIER, 2);
    }

    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class);
    }
}