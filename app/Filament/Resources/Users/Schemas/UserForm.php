<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
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
                TextInput::make('firstname'),
                TextInput::make('lastname'),
                Select::make('enhanced_verification_status')
                    ->label('Enhanced Verification')
                    ->options([
                        'unsubmitted' => 'Not Required',
                        'required'    => 'Required',
                        'pending'     => 'Pending Review',
                        'approved'    => 'Approved',
                        'rejected'    => 'Rejected',
                    ])
                    ->default('unsubmitted')
                    ->native(false)
                    ->live()
                    ->helperText(fn ($state) => match ($state) {
                        'unsubmitted' => 'Enhanced verification is not required for this user.',
                        'required' => 'User must complete enhanced verification before withdrawing.',
                        'pending' => 'Verification has been submitted and is awaiting review.',
                        'approved' => 'Enhanced verification has been approved. Withdrawal is allowed.',
                        'rejected' => 'Enhanced verification was rejected. Withdrawal remains blocked.',
                        default => null,
                    }),
            ]);
    }
}
