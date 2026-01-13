<?php

namespace App\Filament\Resources\Withdrawals\Tables;

use App\Models\Withdrawal;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WithdrawalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.email')
                    ->label('User')
                    ->weight('medium')
                    ->color('success')
                    ->description(fn (Withdrawal $record) => ucfirst($record->user->name))
                    ->sortable(),
                TextColumn::make('user.wallet')
                    ->label('Wallet')
                    ->weight('medium')
                    ->color('success')
                    ->description(fn (Withdrawal $record) => ucfirst($record->currency))
                    ->sortable(),
                TextColumn::make('amount')
                    ->money('usd')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('address')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('processed_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
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
