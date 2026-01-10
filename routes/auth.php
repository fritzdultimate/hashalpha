<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\AuthController;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\TwoFactor;
use Illuminate\Support\Facades\Route;
Route::middleware('guest')->group(function () {
    // Route::get('login', [AuthController::class,'showLogin'])->name('login');
    Route::get('login', Login::class)->name('login');
    Route::post('login', [AuthController::class,'login'])->name('login.attempt');

    Route::get('/register', Register::class)->name('register');
    Route::get('/forgot-password', ForgotPassword::class)->name('password.reset.request');
    Route::get('/reset-password', ResetPassword::class)->name('password.reset');
});
Route::get('/2fa', TwoFactor::class)->name('2fa');

Route::post('logout', [AuthController::class,'logout'])->middleware('auth')->name('logout');