<?php

namespace App\Filament\Widgets;

use App\Enums\DepositStatus;
use App\Models\Deposit;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('Registered users')
                ->color('primary'),
        ];
    }
}
