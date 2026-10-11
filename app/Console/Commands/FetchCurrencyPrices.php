<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Models\CurrencyDailyStat;
use App\Models\CurrencyPrice;
use App\Services\Price\Providers\TabanGoharProvider;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FetchCurrencyPrices extends Command
{
    protected $signature = 'prices:fetch';
    protected $description = 'Fetch current prices from the provider, log them, and update daily stats';

    public function handle(TabanGoharProvider $provider): int
    {
        $result = $provider->getPrice();

        if ($result === false) {
            Log::warning('prices:fetch — provider returned no data');
            return self::FAILURE;
        }

        $payload = $result['data'];

        $fetchedAt = isset($payload['TimeRead'])
            ? Carbon::createFromFormat('Y/m/d H:i:s', $payload['TimeRead'])
            : now();

        unset($payload['TimeRead']);

        $storedCount = 0;
        $skippedCodes = [];

        foreach ($payload as $code => $price) {
            // Non-numeric values are not prices at all.
            if (!is_numeric($price)) {
                continue;
            }

            $price = (float) $price;

            // The provider occasionally glitches and returns 0 (or a negative
            // value) for a moment. Such readings are never recorded.
            if ($price <= 0) {
                $skippedCodes[] = $code;
                continue;
            }

            $storedCount++;

            DB::transaction(function () use ($code, $price, $fetchedAt) {
                $currency = Currency::firstOrCreate(
                    ['code' => $code],
                    ['label' => $code, 'is_active' => true]
                );

                CurrencyPrice::create([
                    'currency_id' => $currency->id,
                    'price' => $price,
                    'fetched_at' => $fetchedAt,
                ]);

                $today = $fetchedAt->toDateString();
                $stat = CurrencyDailyStat::firstOrNew([
                    'currency_id' => $currency->id,
                    'date' => $today,
                ]);

                if (!$stat->exists) {
                    $stat->open = $price;
                    $stat->min = $price;
                    $stat->max = $price;
                } else {
                    $stat->min = min($stat->min, $price);
                    $stat->max = max($stat->max, $price);
                }

                $stat->close = $price;
                $stat->avg = ($stat->min + $stat->max) / 2;
                $stat->save();
            });
        }

        if ($skippedCodes !== []) {
            Log::warning('prices:fetch — skipped zero/invalid prices', [
                'count' => count($skippedCodes),
                'codes' => $skippedCodes,
                'fetched_at' => $fetchedAt->toDateTimeString(),
            ]);
            $this->warn('Skipped zero/invalid prices: ' . count($skippedCodes) . ' (' . implode(', ', $skippedCodes) . ')');
        }

        $this->info('Prices fetched and stored: ' . $storedCount . ' currencies.');
        return self::SUCCESS;
    }
}
