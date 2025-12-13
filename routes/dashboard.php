<?php
use App\Http\Controllers\ProfileController;

use App\Livewire\Dashboard\Affiliate\Bonuses;
use App\Livewire\Dashboard\Affiliate\RankProgress;
use App\Livewire\Dashboard\Affiliate\ReferralCenter;
use App\Livewire\Dashboard\Affiliate\TeamDashboard;
use App\Livewire\Dashboard\StakesIndex;
use App\Livewire\EarningsPage;
use App\Livewire\PlansList;
use App\Livewire\Dashboard\Deposit\Create as CreateDeposit;
use App\Livewire\Dashboard\Deposit\History as DepositHistory;
use App\Livewire\Dashboard\Overview;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', Overview::class)->name('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/staking/deposit', CreateDeposit::class)->name('deposit.create');
    Route::get('/staking/history', DepositHistory::class)->name('deposit.history');
    Route::get('/staking/stake', PlansList::class)->name('staking.stake');
    Route::get('/staking/earnings', EarningsPage::class)->name('staking.earnings');

    Route::get('/stakes', StakesIndex::class)->name('stakes.index');


    Route::get('/stakes/item/{id}', StakesIndex::class)->name('stakes.item');
});

// Affiliate
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/affiliate/center', ReferralCenter::class)->name('referral.center');
    Route::get('/affiliate/team', TeamDashboard::class)->name('referral.team');
    Route::get('/affiliate/bonus', Bonuses::class)->name('referral.bonus');
    Route::get('/affiliate/rank-progress', RankProgress::class)->name('referral.progress');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/withdrawal', Overview::class)->name('withdrawal');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

