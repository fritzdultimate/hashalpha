<?php

namespace App\Filament\Resources\Stakes\Tables;

use App\Enums\StakeStatus;
use App\Models\Stake;
use App\Services\StakeService;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StakesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.email')
                    ->label('User')
                    ->weight('medium')
                    ->color('info')
                    ->description(fn (Stake $record) => ucfirst($record->user->name))
                    ->searchable(),

                TextColumn::make('plan.name')
                    ->label('Plan')
                    ->badge()
                    ->weight('medium')
                    ->color('info'),
                
                TextColumn::make('amount')
                    ->money('usd')
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    Action::make('cancel')
                        ->label('Cancel')
                        ->color('danger')
                        ->icon('heroicon-o-x-mark')
                        ->requiresConfirmation()
                        ->visible(fn (Stake $record) =>
                            $record->status !== StakeStatus::FINISHED && $record->status !== StakeStatus::CANCELLED && $record->status !== StakeStatus::FAILED && $record->status !== StakeStatus::EXPIRED
                        )
                        ->action(function (Stake $record) {
                            $record->status = StakeStatus::CANCELLED;
                            $record->save();
                        }),

                    Action::make('approve')
                        ->label('Approve')
                        ->color('success')
                        ->icon('heroicon-o-check')
                        ->requiresConfirmation()
                        ->visible(fn (Stake $record) =>
                            $record->status !== StakeStatus::FINISHED && $record->status !== StakeStatus::CANCELLED && $record->status !== StakeStatus::FAILED && $record->status !== StakeStatus::EXPIRED
                        )
                        ->action(function (Stake $record) {
                            StakeService::markAsFinished($record);
                        }),
                    DeleteAction::make(),
                ])
                ->label('Action')
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
