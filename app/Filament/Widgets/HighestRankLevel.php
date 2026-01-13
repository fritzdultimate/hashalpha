<?php

namespace App\Filament\Widgets;

use App\Models\Rank;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class HighestRankLevel extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(
                'Highest Rank',
                Rank::max('level') ?? 0
            )
            ->description('Top progression level')
            ->icon('heroicon-o-arrow-trending-up')
            ->color('success'),
        ];
    }
}
