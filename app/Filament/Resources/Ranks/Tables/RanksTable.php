<?php

namespace App\Filament\Resources\Ranks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RanksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Rank')
                    ->weight('bold')
                    ->icon('heroicon-o-star')
                    ->color('primary')
                    ->searchable(),
                BadgeColumn::make('level')
                    ->colors([
                        'gray' => fn ($state) => $state <= 1,
                        'info' => fn ($state) => $state >= 2 && $state <= 3,
                        'warning' => fn ($state) => $state >= 4 && $state <= 6,
                        'success' => fn ($state) => $state >= 7,
                    ])
                    ->sortable(),
                TextColumn::make('required_volume')
                    ->label('Required Volume')
                    ->numeric()
                    ->money('USD')
                    ->sortable()
                    ->icon('heroicon-o-chart-bar')
                    ->color('success'),

                TextColumn::make(name: 'required_active_referrals')
                    ->label('Active Referrals')
                    ->numeric()
                    ->sortable()
                    ->icon('heroicon-o-users')
                    ->alignCenter(),

                TextColumn::make('required_earnings')
                    ->label('Required Earnings')
                    ->numeric()
                    ->money('USD')
                    ->sortable()
                    ->icon('heroicon-o-banknotes')
                    ->color('warning'),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->color('gray'),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ])
            ->striped()
             ->defaultSort('level', 'asc');
    }
}
