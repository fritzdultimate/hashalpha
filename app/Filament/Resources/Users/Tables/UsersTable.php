<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // 👤 USER IDENTITY
                TextColumn::make('name')
                    ->label('User')
                    ->description(fn ($record) => $record->email)
                    ->searchable(['name', 'email'])
                    ->weight('medium')
                    ->color('info')
                    ->icon('heroicon-o-user'),
                IconColumn::make('email_verified_at')
                    ->label('Email')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                TextColumn::make('userRank.rank.name')
                    ->label('Rank')
                    ->badge()
                    ->color(fn ($state) => match (strtolower($state ?? '')) {
                        'bronze' => 'warning',
                        'silver' => 'gray',
                        'gold' => 'amber',
                        'platinum' => 'info',
                        'diamond' => 'success',
                        default => 'secondary',
                    })
                    ->sortable()
                    ->placeholder('Unranked'),

                TextColumn::make('kyc_status')
                    ->searchable(),
                TextColumn::make('kyc_submitted_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('blocked_at')
                    ->dateTime()
                    ->sortable(),
                IconColumn::make('email_verified')
                    ->boolean(),
                IconColumn::make('two_factor_enabled')
                    ->boolean(),
                IconColumn::make('is_suspended')
                    ->boolean(),
                TextColumn::make('suspended_until')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('failed_logins')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('last_failed_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('two_factor_channel')
                    ->searchable(),
                TextColumn::make('firstname')
                    ->searchable(),
                TextColumn::make('lastname')
                    ->searchable(),
                TextColumn::make('balance')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
