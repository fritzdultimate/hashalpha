<?php

use App\Jobs\EvaluateUserRanks;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


// Schedule::call(function () {

//     Log::info('Scheduler hit: Running queued jobs manually from DB');

//     // Get all pending jobs from the database
//     $jobs = DB::table('jobs')->get();

//     if ($jobs->isEmpty()) {
//         Log::info('No jobs found in the jobs table.');
//         return;
//     }

//     foreach ($jobs as $job) {
//         try {
//             // Laravel stores the job as a payload JSON
//             $payload = json_decode($job->payload, true);

//             // Get the job class name
//             $jobClass = $payload['data']['command'] ?? null;

//             if ($jobClass) {
//                 // Unserialize the job
//                 $command = unserialize($jobClass);

//                 if (method_exists($command, 'handle')) {
//                     $command->handle();
//                     Log::info('Manually ran job: ' . get_class($command));
//                 }
//             }

//             // Delete job from table after running
//             DB::table('jobs')->where('id', $job->id)->delete();

//         } catch (\Exception $e) {
//             Log::error('Error running job ID ' . $job->id . ': ' . $e->getMessage());
//         }
//     }

// })->everyMinute();

// Schedule::job(new EvaluateUserRanks())
//     ->hourly()
//     ->withoutOverlapping();

// Schedule::command('app:process-performance-bonus')
//     ->dailyAt('00:00')
//     ->timezone('UTC');



Schedule::call(function () {
    \Log::info('Logging every 5 sec');
})->everyFiveSeconds();