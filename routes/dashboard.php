<?php
use App\Http\Controllers\ProfileController;

use App\Livewire\Dashboard\Account\Details;
use App\Livewire\Dashboard\Account\Kyc;
use App\Livewire\Dashboard\Account\Settings;
use App\Livewire\Dashboard\Account\Support;
use App\Livewire\Dashboard\Account\Wallets;
use App\Livewire\Dashboard\Account\Withdrawal;
use App\Livewire\Dashboard\Account\WithdrawalHistory;
use App\Livewire\Dashboard\Affiliate\Bonuses;
use App\Livewire\Dashboard\Affiliate\Leaderboard;
use App\Livewire\Dashboard\Affiliate\LeaderboardComingSoon;
use App\Livewire\Dashboard\Affiliate\LeaderboardPhaseTwo;
use App\Livewire\Dashboard\Affiliate\LeaderboardTemp;
use App\Livewire\Dashboard\Affiliate\PerformanceBonusDashboard;
use App\Livewire\Dashboard\Affiliate\RankProgress;
use App\Livewire\Dashboard\Affiliate\ReferralCenter;
use App\Livewire\Dashboard\Affiliate\Sprint;
use App\Livewire\Dashboard\Affiliate\TeamDashboard;
use App\Livewire\Dashboard\Extras\ComingSoon;
use App\Livewire\Dashboard\StakesIndex;
use App\Livewire\Dashboard\Transparency\ProofOfRewards;
use App\Livewire\Dashboard\Transparency\Reports;
use App\Livewire\Dashboard\Transparency\SystemStatus;
use App\Livewire\Dashboard\Transparency\Validator;
use App\Livewire\EarningsPage;
use App\Livewire\PlansList;
use App\Livewire\Dashboard\Deposit\Create as CreateDeposit;
use App\Livewire\Dashboard\Deposit\History as DepositHistory;
use App\Livewire\Dashboard\Overview;
use App\Livewire\ReferralRewards;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/chain/vnft', 'nft.index')->name('vnft');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', Overview::class)->name('dashboard');
    Route::get('/extras/coming-soon', ComingSoon::class)->name('coming-soon');
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

    Route::get('/affiliate/leaderboard', Leaderboard::class)->name('leaderboard');

    Route::get('/affiliate/leaderboard/sprint/ii', Sprint::class);

    Route::get('/affiliate/leaderboard/push', LeaderboardComingSoon::class)->name('leaderboard.push');

    Route::get('/affiliate/leaderboard-coming-soon', LeaderboardComingSoon::class);


    Route::get('/affiliate/performance', PerformanceBonusDashboard::class)->name('referral.performance');

});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('transparency')->middleware(['auth'])->group(function () {
        Route::get('/validator', Validator::class)->name('transparency.validator');
        // Route::get('/rewards', ProofOfRewards::class)->name('transparency.rewards');
        Route::get('/reports', Reports::class)->name('transparency.reports');
        Route::get('/system-status', SystemStatus::class)->name('transparency.status');
    });
});

// Account
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/account/referral-bonuses', ReferralRewards::class)->name('account.referral.rewards');
    Route::get('/account/kyc', Kyc::class)->name('account.kyc');
    Route::get('/account/wallet', Wallets::class)->name('account.wallets');
    Route::get('/account/withdrawal', Withdrawal::class)->name('account.withdrawal');
    Route::get('/account/withdrawal/history', WithdrawalHistory::class)->name('withdrawal.history');
    Route::get('/account/settings', Settings::class)->name('account.settings');
    Route::get('/account/support', Support::class)->name('account.support');

    Route::get('/account/settings/dtails', Details::class)->name('account.details');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/withdrawal', Overview::class)->name('withdrawal');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/admin/stop-impersonation', function () {

    abort_unless(session()->has('impersonator_id'), 403);

    $adminId = session()->pull('impersonator_id');

    Auth::loginUsingId($adminId);
    session()->regenerate();

    return redirect('/admin');
})->name('admin.stop-impersonation');

