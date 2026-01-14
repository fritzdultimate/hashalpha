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
                TextInput::make('affiliate_code'),
                TextInput::make('referrer.name')
                    ->label('Referrer')
                    ->placeholder('_'),
                Toggle::make('is_suspended')
                    ->required(),
                TextInput::make('failed_logins')
                    ->required()
                    ->numeric()
                    ->default(0),
                DateTimePicker::make('last_failed_at')
                    ->placeholder('_'),
                TextInput::make('firstname'),
                TextInput::make('lastname'),
            ]);
    }
}
