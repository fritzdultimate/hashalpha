<?php

namespace App\Filament\Resources\StakingPlans\Pages;

use App\Filament\Resources\StakingPlans\StakingPlanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStakingPlan extends EditRecord
{
    protected static string $resource = StakingPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
