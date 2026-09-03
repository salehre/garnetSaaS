<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price_unit', 'is_active', 'allowed_domain', 'balance'];

    protected $casts = [
        'is_active' => 'boolean',
        'balance' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (Customer $customer) {
            if (empty($customer->api_key)) {
                $customer->api_key = static::generateUniqueApiKey();
            }
        });
    }

    public static function generateUniqueApiKey(): string
    {
        do {
            $key = Str::random(40);
        } while (static::where('api_key', $key)->exists());

        return $key;
    }

    public function currencies(): BelongsToMany
    {
        return $this->belongsToMany(Currency::class, 'customer_currency');
    }

    public function externalServices(): BelongsToMany
    {
        return $this->belongsToMany(ExternalService::class, 'customer_external_service');
    }

    public function walletTransactions(): HasMany
    {
        return $this->hasMany(CustomerWalletTransaction::class);
    }

    public function convertPrice(float $tomanPrice): float
    {
        return $this->price_unit === 'rial' ? $tomanPrice * 10 : $tomanPrice;
    }

    public function domainIsAllowed(?string $requestHost): bool
    {
        if (empty($this->allowed_domain)) {
            return true;
        }

        if (empty($requestHost)) {
            return false;
        }

        return strcasecmp($requestHost, $this->allowed_domain) === 0;
    }

    public function hasService(string $slug): bool
    {
        return $this->externalServices()->where('slug', $slug)->exists();
    }

    public function chargeForService(ExternalService $service, string $description): bool
    {
        return DB::transaction(function () use ($service, $description) {
            $customer = static::where('id', $this->id)->lockForUpdate()->first();

            if ($customer->balance < $service->price) {
                return false;
            }

            $customer->balance -= $service->price;
            $customer->save();

            CustomerWalletTransaction::create([
                'customer_id' => $customer->id,
                'type' => 'debit',
                'amount' => $service->price,
                'balance_after' => $customer->balance,
                'description' => $description,
            ]);

            $this->balance = $customer->balance;

            return true;
        });
    }

    public function creditBalance(float $amount, string $description): void
    {
        DB::transaction(function () use ($amount, $description) {
            $customer = static::where('id', $this->id)->lockForUpdate()->first();

            $customer->balance += $amount;
            $customer->save();

            CustomerWalletTransaction::create([
                'customer_id' => $customer->id,
                'type' => 'credit',
                'amount' => $amount,
                'balance_after' => $customer->balance,
                'description' => $description,
            ]);

            $this->balance = $customer->balance;
        });
    }
}