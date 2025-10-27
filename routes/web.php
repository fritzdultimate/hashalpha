<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'landing.home')->name('home');
Route::view('/about', 'landing.about')->name('about');
Route::view('/staking', 'landing.staking')->name('staking');
Route::view('/rewards', 'landing.rewards')->name('rewards');
Route::view('/transparency', 'landing.transparency')->name('transparency');
Route::view('/affiliate', 'landing.affiliate')->name('affiliate');
Route::view('/resources', 'landing.resources')->name('resources');
Route::view('/support', 'landing.support')->name('support');

require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';
