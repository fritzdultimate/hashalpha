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
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class,'showLogin'])->name('login');
    Route::post('login', [AuthController::class,'login'])->name('login.attempt');

    Route::get('register', [AuthController::class,'showRegister'])->name('register');
    Route::post('register', [AuthController::class,'register'])->name('register.attempt');

    Route::get('password/forgot', [AuthController::class,'showForgot'])->name('password.request');
    Route::post('password/forgot', [AuthController::class,'sendResetLink'])->name('password.email');
    Route::get('password/reset/{token}', [AuthController::class,'showReset'])->name('password.reset');
    Route::post('password/reset', [AuthController::class,'resetPassword'])->name('password.update');

    Route::get('2fa', [AuthController::class,'showTwoFactor'])->name('2fa');
    Route::post('2fa', [AuthController::class,'verifyTwoFactor'])->name('2fa.verify');

    Route::get('recovery-codes', [AuthController::class,'showRecoveryCodes'])->name('recovery.codes');
});

Route::post('logout', [AuthController::class,'logout'])->middleware('auth')->name('logout');