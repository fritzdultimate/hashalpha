<?php

namespace App\Filament\Resources\PerformancePercentages\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class PerformancePercentageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('rank_id')
                    ->label('Rank')
                    ->relationship(
                        'rank',
                        'name',
                        fn (Builder $query) => $query->orderBy('level', 'asc')
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('level')
                    ->required()
                    ->numeric(),
                TextInput::make('percentage')
                    ->required()
                    ->numeric(),
            ]);
    }
}
