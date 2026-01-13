<?php

namespace App\Filament\Widgets;

use App\Models\Rank;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AverageRankRequirements extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(
                'Avg Volume',
                number_format(Rank::avg('required_volume'), 2)
            )
                ->description('Average required volume')
                ->icon('heroicon-o-chart-bar')
                ->color('info'),

            Stat::make(
                'Avg Earnings',
                number_format(Rank::avg('required_earnings'), 2)
            )
                ->description('Average earnings needed')
                ->icon('heroicon-o-banknotes')
                ->color('warning'),
        ];
    }
}
