<?php

use App\Http\Controllers\BeaconController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\HardNowPaymentsController;
use App\Http\Controllers\NowPaymentsController;
use Illuminate\Support\Facades\Route;

Route::get('/transparency/beacon', [BeaconController::class, 'publicStatus'])->name('api-beacon');

Route::post('/webhooks/nowpayments', [NowPaymentsController::class, 'webhook'])->name('webhooks.nowpayments');

Route::post('/webhooks/hardnowpayments', [HardNowPaymentsController::class, 'webhook'])->name('webhooks.hardnowpayments');

Route::get('/deposit/status/{id}', [DepositController::class, 'pollDeposit']);
Route::post('/deposit/cancel/{id}', [DepositController::class, 'cancelDeposit']);
