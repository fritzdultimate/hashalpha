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
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (StakeStatus  $state): string => $state->color())      
                    ->searchable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('last_payout_at')
                    ->label('Last Payout')
                    ->placeholder('—')
                    // ->formatStateUsing(fn ($state) => $state ? $state->format('M d, Y H:i') : 'Not paid yet')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
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
                            $record->status !== StakeStatus::COMPLETED && $record->status !== StakeStatus::CANCELLED
                        )
                        ->action(function (Stake $record) {
                            $record->status = StakeStatus::CANCELLED;
                            $record->save();
                        }),

                    Action::make('pause')
                        ->label('Pause')
                        ->color('warning')
                        ->icon('heroicon-o-pause')
                        ->requiresConfirmation()
                        ->visible(fn (Stake $record) =>
                            $record->status !== StakeStatus::COMPLETED && $record->status !== StakeStatus::CANCELLED && $record->status !== StakeStatus::PAUSED
                        )
                        ->action(function (Stake $record) {
                            StakeService::pause($record);
                        }),

                    Action::make('approve')
                        ->label('Resume')
                        ->color('success')
                        ->icon('heroicon-o-play')
                        ->requiresConfirmation()
                        ->visible(fn (Stake $record) =>
                            $record->status === StakeStatus::PAUSED
                        )
                        ->action(function (Stake $record) {
                            StakeService::resume($record);
                        }),

                    Action::make('lockReward')
                        ->label('Lock Reward')
                        ->color('warning')
                        ->icon('heroicon-o-lock-closed')
                        ->requiresConfirmation()
                        ->visible(fn (Stake $record) =>
                            $record->status === StakeStatus::ACTIVE &&
                            $record->lock_roi === false
                        )
                        ->action(function (Stake $record) {
                            StakeService::lockReward($record);
                        }),

                    Action::make('unlockReward')
                        ->label('Unlock Reward')
                        ->color('success')
                        ->icon('heroicon-o-lock-open')
                        ->requiresConfirmation()
                        ->visible(fn (Stake $record) =>
                            $record->status === StakeStatus::ACTIVE &&
                            $record->lock_roi === true
                        )
                        ->action(function (Stake $record) {
                            StakeService::unlockReward($record);
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
