<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
                TextInput::make('affiliate_code'),
                TextInput::make('referrer_id')
                    ->numeric(),
                TextInput::make('kyc_status')
                    ->required()
                    ->default('unsubmitted'),
                DateTimePicker::make('kyc_submitted_at'),
                DateTimePicker::make('blocked_at'),
                Toggle::make('email_verified')
                    ->required(),
                Toggle::make('two_factor_enabled')
                    ->required(),
                Toggle::make('is_suspended')
                    ->required(),
                DateTimePicker::make('suspended_until'),
                TextInput::make('failed_logins')
                    ->required()
                    ->numeric()
                    ->default(0),
                DateTimePicker::make('last_failed_at'),
                TextInput::make('two_factor_channel'),
                TextInput::make('firstname'),
                TextInput::make('lastname'),
                TextInput::make('balance')
                    ->required()
                    ->numeric()
                    ->default(505),
            ]);
    }
}
