<?php

use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GenerateValidatorReward;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProcessStakeRewards;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SupportController;
use Illuminate\Support\Facades\Route;

Route::get('/cron/process-stake-rewards', [ProcessStakeRewards::class, 'handle'])
    ->name('cron.process-stake-rewards');

Route::get('/cron/process-validator-rewards', [GenerateValidatorReward::class, 'handle'])
    ->name('cron.process-validator-rewards');

Route::get('/', [PageController::class, 'index'])->name('home');
Route::view('/about', 'landing.about')->name('about');
Route::view('/staking', 'landing.staking')->name('staking');
Route::view('/rewards', 'landing.rewards')->name('rewards');
Route::view('/nfts', 'landing.nfts')->name('nfts');
Route::view('/$hash/token', 'landing.hash-token')->name('hash-token');
// Transparency
Route::view('/transparency', 'landing.transparency')->name('transparency');
Route::view('/transparency/explorer', 'landing.transparency.validator-explorer')->name('validator-explorer');
Route::view('/transparency/rewards', 'landing.transparency.proof-of-stake-rewards')->name('proof-of-stake-rewards');
Route::view('/transparency/reports', 'landing.transparency.operation-reports')->name('operation-reports');
Route::view('/transparency/audits', 'landing.transparency.audit-dashboard')->name('audits');
Route::view('/transparency/beacon', 'landing.transparency.beacon-data')->name('beacon');

Route::get('/terms-and-conditions', [LegalController::class, 'terms'])->name('terms');

// //////////// //////////////////////
/////////////////////////////////////
//////////////////////////////////////
////////////////////////////////////// 
///////////                 //////////
///////////  TRANSPARENCY   /////////////
///////////             ///////////////
///////////////////////////////////////

Route::prefix('affiliate')->group(function () {
    Route::get('/', [AffiliateController::class, 'index'])->name('affiliate.index');
    Route::get('/ranks', [AffiliateController::class, 'ranks'])->name('affiliate.ranks');
    Route::get('/compensation', [AffiliateController::class, 'compensation'])->name('affiliate.compensation');
    Route::get('/tools', [AffiliateController::class, 'tools'])->name('affiliate.tools');
});

Route::prefix('docs')->group(function () {
    Route::get('/', [ResourceController::class, 'index'])->name('resources.index');
    Route::get('/roadmap', [ResourceController::class, 'roadmap'])->name('resources.roadmap');
    Route::get('/whitepaper/download', [ResourceController::class, 'downloadWhitepaper'])->name('resources.whitepaper.download');
    Route::get('/media-kit/download', [ResourceController::class, 'downloadMediaKit'])->name('resources.media.download');
});

Route::get('/blog', [BlogController::class, 'index'])->name('blog');

Route::prefix('support')->group(function () {
    Route::get('/', [SupportController::class, 'index'])->name('support.index');
    Route::get('/contact', [SupportController::class, 'contactForm'])->name('support.contact');
    Route::post('/contact', [SupportController::class, 'submitContact'])->name('support.contact.submit');

    Route::get('/livechat', [SupportController::class, 'liveChat'])->name('support.chat');

    Route::get('/kyc', [SupportController::class, 'kycForm'])->name('support.kyc');
    Route::post('/kyc', [SupportController::class, 'submitKyc'])->name('support.kyc.submit');

    Route::get('/faq', [SupportController::class, 'faq'])->name('support.faq');

    Route::get('/report', [SupportController::class, 'reportForm'])->name('support.report');
    Route::post('/report', [SupportController::class, 'submitReport'])->name('support.report.submit');

    // Optional: agent/admin ticket routes (behind middleware->can('support.manage'))
    Route::middleware(['auth','can:support.manage'])->group(function () {
        Route::get('/tickets', [SupportController::class, 'tickets'])->name('support.tickets');
        Route::get('/ticket/{id}', [SupportController::class, 'viewTicket'])->name('support.ticket.view');
        Route::post('/ticket/{id}/comment', [SupportController::class, 'commentTicket'])->name('support.ticket.comment');
        Route::post('/ticket/{id}/status', [SupportController::class, 'changeTicketStatus'])->name('support.ticket.status');
    });
});

Route::get('/terms', function() {
    return 'Our Terms';
})->name('terms');

Route::get('/privacy-policy', function() {
    return 'Privacy Policy';
})->name('privacy-policy');

Route::view('email-template', 'emaim-template');

require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php'; 
