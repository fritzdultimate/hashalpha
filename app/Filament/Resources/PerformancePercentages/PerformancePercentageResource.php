<?php

namespace App\Filament\Resources\PerformancePercentages;

use App\Filament\Resources\PerformancePercentages\Pages\CreatePerformancePercentage;
use App\Filament\Resources\PerformancePercentages\Pages\EditPerformancePercentage;
use App\Filament\Resources\PerformancePercentages\Pages\ListPerformancePercentages;
use App\Filament\Resources\PerformancePercentages\Schemas\PerformancePercentageForm;
use App\Filament\Resources\PerformancePercentages\Tables\PerformancePercentagesTable;
use App\Models\PerformancePercentage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PerformancePercentageResource extends Resource
{
    protected static ?string $model = PerformancePercentage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return PerformancePercentageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PerformancePercentagesTable::configure($table);
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
            'index' => ListPerformancePercentages::route('/'),
            'create' => CreatePerformancePercentage::route('/create'),
            'edit' => EditPerformancePercentage::route('/{record}/edit'),
        ];
    }
}
