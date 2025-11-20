<?php
use App\Http\Controllers\NowPaymentsController;
use App\Http\Controllers\ProfileController;

use App\Livewire\Dashboard\Deposit\Create as CreateDeposit;
use App\Livewire\Dashboard\Overview;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', Overview::class)->name('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/deposit/create', CreateDeposit::class)->name('deposit.create');
    Route::get('/deposit/approved', Overview::class)->name('deposit.approved');
    Route::get('/deposit/denied', Overview::class)->name('deposit.denied');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/withdrawal', Overview::class)->name('withdrawal');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/webhooks/nowpayments', [NowPaymentsController::class, 'webhook'])->name('webhooks.nowpayments');

