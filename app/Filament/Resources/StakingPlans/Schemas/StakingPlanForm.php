<?php

namespace App\Filament\Resources\StakingPlans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class StakingPlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('min_amount')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('max_amount')
                    ->numeric(),
                TextInput::make('daily_roi')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('payout_frequency')
                    ->required()
                    ->default('daily'),
                Toggle::make('compound_allowed')
                    ->required(),
                Textarea::make('rules')
                    ->columnSpanFull(),
                TextInput::make('duration')
                    ->required()
                    ->numeric()
                    ->default(7),
            ]);
    }
}
