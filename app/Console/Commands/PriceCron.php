<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Throwable;

class PriceCron extends Command
{
    protected $signature = 'prices:cron';
    protected $description = 'Single cron entry point: runs prices:fetch every minute, and fires prices:snapshot / prices:prune exactly on their clock boundaries — all in one process, no proc_open needed';

    private const SNAPSHOT_INTERVALS = [
        '2h' => 2,
        '6h' => 6,
        '12h' => 12,
        '24h' => 24,
    ];

    public function handle(): int
    {
        $now = now();

        $this->runTask('prices:fetch');

        if ($now->minute === 0) {
            foreach (self::SNAPSHOT_INTERVALS as $interval => $hoursPerBucket) {
                if ($now->hour % $hoursPerBucket === 0) {
                    $this->runTask('prices:snapshot', ['interval' => $interval]);
                }
            }

            $this->runTask('prices:prune');
        }

        return self::SUCCESS;
    }

    private function runTask(string $command, array $parameters = []): void
    {
        try {
            Artisan::call($command, $parameters);
        } catch (Throwable $e) {
            Log::error("prices:cron — task [{$command}] failed: {$e->getMessage()}");
        }
    }
}