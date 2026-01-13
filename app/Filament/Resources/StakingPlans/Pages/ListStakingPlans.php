<?php

namespace App\Filament\Resources\StakingPlans\Pages;

use App\Filament\Resources\StakingPlans\StakingPlanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStakingPlans extends ListRecords
{
    protected static string $resource = StakingPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
