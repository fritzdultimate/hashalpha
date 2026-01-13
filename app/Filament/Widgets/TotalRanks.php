<?php

namespace App\Filament\Widgets;

use App\Models\Rank;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalRanks extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Ranks', Rank::count())
                ->description('Configured ranking levels')
                ->icon('heroicon-o-star')
                ->color('primary'),
        ];
    }
}
