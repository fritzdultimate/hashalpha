<?php

namespace App\Filament\Resources\Stakes;

use App\Filament\Resources\Stakes\Pages\CreateStake;
use App\Filament\Resources\Stakes\Pages\EditStake;
use App\Filament\Resources\Stakes\Pages\ListStakes;
use App\Filament\Resources\Stakes\Schemas\StakeForm;
use App\Filament\Resources\Stakes\Tables\StakesTable;
use App\Models\Stake;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StakeResource extends Resource
{
    protected static ?string $model = Stake::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return StakeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StakesTable::configure($table);
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
            'index' => ListStakes::route('/'),
            'create' => CreateStake::route('/create'),
            'edit' => EditStake::route('/{record}/edit'),
        ];
    }
}
