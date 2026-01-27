<?php

namespace App\Filament\Resources\Stakes\Schemas;

use App\Enums\StakeStatus;
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
                ->options(
                    User::query()
                        ->orderBy('name')
                        ->get()
                        ->mapWithKeys(fn ($user) => [
                            $user->id => "{$user->name} ({$user->email})"
                        ])
                        ->toArray()
                ),
                TextInput::make('amount')
                    ->label('Amount')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->rules(fn (callable $get) => self::amountRules($get))
                    ->helperText(fn (callable $get) =>  self::amountHint($get)),

                Select::make('plan_id')
                    ->label('Staking Plan')
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->options(
                        StakingPlan::query()
                            ->orderBy('min_amount')
                            ->pluck('name', 'id')
                            ->toArray()
                    ),

                Select::make('status')
                    ->label('Status')
                    ->required()
                    ->default(StakeStatus::ACTIVE->value)
                    ->options(
                        collect(StakeStatus::cases())
                            ->mapWithKeys(fn (StakeStatus $status) => [
                                $status->value => $status->label(),
                            ])
                            ->toArray()
                    ),
            ]);
    }

    protected static function amountRules(callable $get): array
    {
        $planId = $get('plan_id');

        if (! $planId) {
            return ['numeric', 'min:0'];
        }

        $plan = StakingPlan::find($planId);

        if (! $plan) {
            return ['numeric', 'min:0'];
        }

        return [
            'numeric',
            'min:' . $plan->min_amount,
            'max:' . $plan->max_amount,
        ];
    }

    protected static function amountHint(callable $get): ?string
    {
        $planId = $get('plan_id');

        if (! $planId) {
            return null;
        }

        $plan = StakingPlan::find($planId);

        if (! $plan) {
            return null;
        }

        return "Min: {$plan->min_amount} — Max: {$plan->max_amount}";
    }
}
