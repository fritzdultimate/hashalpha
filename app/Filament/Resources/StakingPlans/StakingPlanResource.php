<?php

namespace App\Filament\Resources\StakingPlans;

use App\Filament\Resources\StakingPlans\Pages\CreateStakingPlan;
use App\Filament\Resources\StakingPlans\Pages\EditStakingPlan;
use App\Filament\Resources\StakingPlans\Pages\ListStakingPlans;
use App\Filament\Resources\StakingPlans\Schemas\StakingPlanForm;
use App\Filament\Resources\StakingPlans\Tables\StakingPlansTable;
use App\Models\StakingPlan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StakingPlanResource extends Resource
{
    protected static ?string $model = StakingPlan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return StakingPlanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StakingPlansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStakingPlans::route('/'),
            'create' => CreateStakingPlan::route('/create'),
            'edit' => EditStakingPlan::route('/{record}/edit'),
        ];
    }
}
