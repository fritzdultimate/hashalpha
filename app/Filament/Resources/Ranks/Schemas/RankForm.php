<?php

namespace App\Filament\Resources\Ranks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RankForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('level')
                    ->required()
                    ->numeric(),
                TextInput::make('required_volume')
                    ->required()
                    ->numeric(),
                TextInput::make('required_active_referrals')
                    ->required()
                    ->numeric(),
                TextInput::make('required_earnings')
                    ->required()
                    ->numeric(),
            ]);
    }
}
