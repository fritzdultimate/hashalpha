<?php

namespace App\Filament\Resources\Stakes\Tables;

use App\Enums\StakeStatus;
use App\Models\Stake;
use App\Models\StakingPlan;
use App\Services\StakeService;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
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

                IconColumn::make('paid_withdrawal_fee')
                    ->label('Withdrawal Fee')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                IconColumn::make('lock_roi')
                    ->label('ROI Lock')
                    ->boolean()
                    ->trueIcon('heroicon-o-lock-closed')
                    ->falseIcon('heroicon-o-lock-open')
                    ->trueColor('danger')
                    ->falseColor('success'),

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

                    Action::make('endStake')
                        ->label('End Stake')
                        ->color('danger')
                        ->icon('heroicon-o-flag')
                        ->requiresConfirmation()
                        ->visible(fn (Stake $record) =>
                            $record->status === StakeStatus::ACTIVE
                        )
                        ->form([
                            Select::make('plan_id')
                                ->label('New Plan')
                                ->options(fn () => StakingPlan::where('for_compounding', true)->pluck('name', 'id'))
                                ->searchable()
                                ->required(),
                        ])
                        ->modalDescription('Select new plan for compounding.')
                        ->action(function (Stake $record, array $data) {
                            StakeService::endStake($record, StakingPlan::findOrFail($data['plan_id']));
                        }),

                    // Mark maintenance fee paid
                    Action::make('markWithdrawalFeePaid')
                        ->label('Mark Fee Paid')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn ($record) => ! $record->paid_withdrawal_fee)
                        ->action(function ($record) {

                            abort_if($record->paid_withdrawal_fee, 403);

                            $record->update([
                                'paid_withdrawal_fee' => true,
                            ]);

                            Notification::make()
                                ->title('Withdrawal Fee Marked as Paid')
                                ->success()
                                ->send();
                        })
                        ->modalHeading('Mark Withdrawal Fee as Paid')
                        ->modalDescription('Confirm this user has paid their withdrawal fee.'),

                    // Mark withdrawal fee unpaid
                    Action::make('markWithdrawalFeeUnpaid')
                        ->label('Mark Fee Unpaid')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->visible(fn ($record) => $record->paid_withdrawal_fee)
                        ->action(function ($record) {

                            abort_unless($record->paid_withdrawal_fee, 403);

                            $record->update([
                                'paid_withdrawal_fee' => false,
                            ]);

                            Notification::make()
                                ->title('Withdrawal Fee Marked as Unpaid')
                                ->danger()
                                ->send();
                        })
                        ->modalHeading('Mark Withdrawal Fee as Unpaid')
                        ->modalDescription('This will mark the user as not having paid their withdrawal fee.'),

                    
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
