<?php

namespace App\Console\Commands;

use App\Models\CurrencyPrice;
use App\Models\CurrencyPriceSnapshot;
use Illuminate\Console\Command;

class PrunePriceData extends Command
{
    protected $signature = 'prices:prune';
    protected $description = 'Delete data older than each table\'s own rolling retention window';

    public function handle(): int
    {
        $rawDeleted = CurrencyPrice::where('fetched_at', '<', now()->subHours(24))->delete();

        $weeklyDeleted = CurrencyPriceSnapshot::where('interval_type', '2h')
            ->where('snapshotted_at', '<', now()->subDays(7))
            ->delete();

        $monthlyDeleted = CurrencyPriceSnapshot::where('interval_type', '6h')
            ->where('snapshotted_at', '<', now()->subMonth())
            ->delete();

        $quarterlyDeleted = CurrencyPriceSnapshot::where('interval_type', '12h')
            ->where('snapshotted_at', '<', now()->subMonths(3))
            ->delete();

        $sixMonthDeleted = CurrencyPriceSnapshot::where('interval_type', '24h')
            ->where('snapshotted_at', '<', now()->subMonths(6))
            ->delete();

        $this->info(sprintf(
            'Pruned — raw: %d, 2h: %d, 6h: %d, 12h: %d, 24h: %d',
            $rawDeleted,
            $weeklyDeleted,
            $monthlyDeleted,
            $quarterlyDeleted,
            $sixMonthDeleted,
        ));

        return self::SUCCESS;
    }
}