<?php

namespace App\Providers;

use App\Events\DepositCreated;
use App\Events\StakeCreated;
use App\Events\UserEmailVerified;
use App\Events\WithdrawalRequested;
use App\Listeners\SendFinancialEmail;
use App\Listeners\SendWelcomeEmail;
use App\Models\Stake;
use App\Observers\TransactionObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        Stake::observe(TransactionObserver::class);

        Event::listen(
            DepositCreated::class,
            SendFinancialEmail::class
        );

        Event::listen(
            UserEmailVerified::class,
            SendWelcomeEmail::class
        );

        // Event::listen(
        //     StakeCreated::class,
        //     SendFinancialEmail::class
        // );

        // Event::listen(
        //     WithdrawalRequested::class,
        //     SendFinancialEmail::class
        // );
    }
}
