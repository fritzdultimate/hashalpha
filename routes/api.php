<?php

use App\Http\Controllers\BeaconController;
use Illuminate\Support\Facades\Route;

Route::get('/transparency/beacon', [BeaconController::class, 'publicStatus'])->name('api-beacon');
