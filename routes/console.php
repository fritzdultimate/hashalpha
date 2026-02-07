<?php

use App\Jobs\EvaluateUserRanks;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;


Schedule::call(function () {
    Log::info('SCHEDULER HIT: schedule:run executed this');
})->everyMinute();

// Schedule::job(new EvaluateUserRanks())
//     ->hourly()
//     ->withoutOverlapping();
