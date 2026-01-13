<?php

namespace App\Filament\Resources\Ranks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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
                TextColumn::make('level')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('required_volume')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('required_active_referrals')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('required_earnings')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ]);
    }
}
