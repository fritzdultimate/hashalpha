<?php

namespace App\Filament\Resources\ReferralLevels\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ReferralLevelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('level')
                    ->numeric()
                    ->required(),

                TextInput::make('percent_bps')
                    ->label('Percentage (Basis Points)')
                    ->numeric()
                    ->helperText('100 = 1%, 10000 = 100%')
                    ->required(),

                TextInput::make('lock_days')
                    ->numeric()
                    ->label('Lock-up Days')
                    ->required(),

                Toggle::make('is_active')
                    ->label('Active'),
                    ]);
    }
}
