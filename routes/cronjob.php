<?php

use App\Http\Controllers\AddValidatorBlock;
use App\Http\Controllers\ClaimValidatorReward;
use App\Http\Controllers\GenerateValidatorReward;
use App\Http\Controllers\ProcessStakeRewards;
use App\Http\Controllers\RankController;

Route::get('/cron/process-stake-rewards', [ProcessStakeRewards::class, 'handle'])
    ->name('cron.process-stake-rewards');

Route::get('/cron/process-validator-rewards', [GenerateValidatorReward::class, 'handle'])
    ->name('cron.process-validator-rewards');

Route::get('/cron/claim-validator-rewards', [ClaimValidatorReward::class, 'handle'])
    ->name('cron.claim-validator-rewards');

Route::get('/cron/add-validator-block', [AddValidatorBlock::class, 'handle'])
    ->name('cron.add-validator-block');

// rank
Route::get('/cron/assign-rank', [RankController::class, 'assignRank'])
    ->name('rank.assign');