<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('prices:fetch')->everyMinute()->withoutOverlapping();

Schedule::command('prices:snapshot 2h')->everyTwoHours();
Schedule::command('prices:snapshot 6h')->cron('0 */6 * * *');
Schedule::command('prices:snapshot 12h')->twiceDaily(0, 12);
Schedule::command('prices:snapshot 24h')->daily();
