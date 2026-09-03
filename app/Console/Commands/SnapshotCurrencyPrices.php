<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Models\CurrencyPriceSnapshot;
use Illuminate\Console\Command;

class SnapshotCurrencyPrices extends Command
{
    protected $signature = 'prices:snapshot {interval : One of 2h,6h,12h,24h}';
    protected $description = 'Compute entry/exit/min/max/avg for each currency over the just-elapsed, clock-aligned bucket';

    /**
     * How many hours each bucket of this interval spans.
     */
    private const INTERVAL_HOURS = [
        '2h' => 2,
        '6h' => 6,
        '12h' => 12,
        '24h' => 24,
    ];

    public function handle(): int
    {
        $interval = $this->argument('interval');

        if (!array_key_exists($interval, self::INTERVAL_HOURS)) {
            $this->error('Invalid interval. Use one of: ' . implode(', ', array_keys(self::INTERVAL_HOURS)));
            return self::FAILURE;
        }

        $hoursPerBucket = self::INTERVAL_HOURS[$interval];
        $now = now();


        $flooredHour = intdiv($now->hour, $hoursPerBucket) * $hoursPerBucket;
        $windowEnd = $now->copy()->startOfDay()->addHours($flooredHour);
        $windowStart = $windowEnd->copy()->subHours($hoursPerBucket);

        $bucketDate = $windowStart->toDateString();
        $bucketRange = sprintf(
            '%02d:00-%02d:00',
            $windowStart->hour,
            $windowStart->hour + $hoursPerBucket
        );

        $storedCount = 0;

        Currency::query()->chunk(50, function ($currencies) use (
            $interval, $windowStart, $windowEnd, $bucketDate, $bucketRange, &$storedCount
        ) {
            foreach ($currencies as $currency) {
                $ticks = $currency->prices()
                    ->where('fetched_at', '>=', $windowStart)
                    ->where('fetched_at', '<', $windowEnd)
                    ->orderBy('fetched_at')
                    ->pluck('price');

                if ($ticks->isEmpty()) {
                    continue;
                }

                $entryPrice = (float) $ticks->first();
                $exitPrice = (float) $ticks->last();
                $minPrice = (float) $ticks->min();
                $maxPrice = (float) $ticks->max();

                CurrencyPriceSnapshot::updateOrCreate(
                    [
                        'currency_id' => $currency->id,
                        'interval_type' => $interval,
                        'bucket_date' => $bucketDate,
                        'bucket_range' => $bucketRange,
                    ],
                    [
                        'entry_price' => $entryPrice,
                        'exit_price' => $exitPrice,
                        'min_price' => $minPrice,
                        'max_price' => $maxPrice,
                        'avg_price' => ($minPrice + $maxPrice) / 2,
                        'snapshotted_at' => $windowStart,
                    ]
                );

                $storedCount++;
            }
        });

        $this->info("Snapshot ({$interval}, bucket {$bucketRange} of {$bucketDate}) recorded for {$storedCount} currencies.");
        return self::SUCCESS;
    }
}