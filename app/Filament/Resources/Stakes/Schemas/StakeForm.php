<?php

namespace App\Filament\Resources\Stakes\Schemas;

use App\Models\StakingPlan;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StakeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('User')
                    ->searchable()
                    ->required()
                    ->options(function () {
                        return User::query()
                            ->orderBy('name')
                            ->get()
                            ->mapWithKeys(fn ($user) => [
                                $user->id => $user->name . ' (' . $user->email . ')'
                            ])
                            ->toArray();
                    }),
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->default(0),

                Select::make('plan_id')
                    ->label('Plan')
                    ->searchable()
                    ->required()
                    ->options(function () {
                        return StakingPlan::query()
                            ->orderBy('name')
                            ->get()
                            ->mapWithKeys(fn ($plan) => [
                                $plan->id => $plan->name
                            ])
                            ->toArray();
                    }),
            ]);
    }
}
