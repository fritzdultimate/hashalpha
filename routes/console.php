<?php

use App\Jobs\EvaluateUserRanks;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// Artisan::command('inspire', function () {
//     Log::info('SCHEDULER HIT: schedule:run executed artisan');
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote');
Log::info('SCHEDULER HIT: schedule:run executed outside');

Schedule::call(function () {
    Log::info('SCHEDULER HIT: schedule:run executed this');
})->everyMinute();

// Schedule::job(new EvaluateUserRanks())
//     ->hourly()
//     ->withoutOverlapping();
