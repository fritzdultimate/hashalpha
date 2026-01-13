<?php

namespace App\Filament\Resources\Deposits\Tables;

use App\Enums\DepositStatus;
use App\Models\Deposit;
use App\Services\DepositService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DepositsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('amount')
                    ->money('usd')
                    ->sortable(),
                // TextColumn::make('address')
                    // ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('currency')
                    ->searchable(),
                TextColumn::make('amount_paid')
                    ->money('usd')
                    ->sortable(),
            ])

            ->filters([
                //
            ])
            ->recordActions([
                Action::make('cancel')
                    ->label('Cancel')
                    ->color('danger')
                    ->icon('heroicon-o-x-mark')
                    ->requiresConfirmation()
                    ->visible(fn (Deposit $record) =>
                        $record->status !== DepositStatus::FINISHED && $record->status !== DepositStatus::CANCELLED && $record->status !== DepositStatus::FAILED
                    )
                    ->action(function (Deposit $record) {
                        $record->status = DepositStatus::CANCELLED;
                        $record->save();
                    }),

                Action::make('approve')
                    ->label('Approve')
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->requiresConfirmation()
                    ->visible(fn (Deposit $record) =>
                        $record->status !== DepositStatus::FINISHED && $record->status !== DepositStatus::CANCELLED && $record->status !== DepositStatus::FAILED
                    )
                    ->action(function (Deposit $record) {
                        DepositService::markAsFinished($record);
                    }),
                DeleteAction::make(),
                EditAction::make()
                    ->visible(fn (Deposit $record) =>
                        $record->status !== DepositStatus::FINISHED && $record->status !== DepositStatus::CANCELLED && $record->status !== DepositStatus::FAILED
                    )  
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
