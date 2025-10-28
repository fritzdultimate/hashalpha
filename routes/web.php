<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'landing.home')->name('home');
Route::view('/about', 'landing.about')->name('about');
Route::view('/staking', 'landing.staking')->name('staking');
Route::view('/rewards', 'landing.rewards')->name('rewards');
// Transparency
Route::view('/transparency', 'landing.transparency')->name('transparency');
Route::view('/transparency/explorer', 'landing.transparency.validator-explorer')->name('validator-explorer');
Route::view('/transparency/rewards', 'landing.transparency.proof-of-stake-rewards')->name('proof-of-stake-rewards');
// //////////// //////////////////////
/////////////////////////////////////
//////////////////////////////////////
////////////////////////////////////// 
///////////                 //////////
///////////  TRANSPARENCY   /////////////
///////////             ///////////////
///////////////////////////////////////
Route::view('/affiliate', 'landing.affiliate')->name('affiliate');
Route::view('/resources', 'landing.resources')->name('resources');
Route::view('/support', 'landing.support')->name('support');

require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';
