<?php

namespace App\Filament\Resources\EnhancedVerifications\Tables;

use App\Mail\EnhancedVerificationApprovedMail;
use App\Mail\EnhancedVerificationRejectedMail;
use App\Models\EnhancedVerification;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;

class EnhancedVerificationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('User')->searchable(),
                BadgeColumn::make('status')
                    ->colors([
                        'success' => 'approved',
                        'danger' => 'rejected',
                        'warning' => 'pending',
                    ]),
                TextColumn::make('certificate_number')->label('Reference')->placeholder('—'),
                TextColumn::make('reviewer.name')->label('Reviewed By')->placeholder('—'),
                TextColumn::make('reviewed_at')->dateTime()->sortable(),
                TextColumn::make('created_at')->label('Submitted')->dateTime(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->recordActions([
                ActionGroup::make([
                    Action::make('approve')
                        ->label('Approve')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (EnhancedVerification $record) {
                            $certificateNumber = 'EV-' . now()->format('Ymd') . '-' . str_pad((string) $record->id, 5, '0', STR_PAD_LEFT);

                            $record->update([
                                'status' => 'approved',
                                'reviewed_by' => auth()->id(),
                                'reviewed_at' => now(),
                                'certificate_number' => $certificateNumber,
                                'certificate_issued_at' => now(),
                            ]);

                            $record->user->update(['enhanced_verification_status' => 'approved']);

                            Mail::to($record->user->email)->send(new EnhancedVerificationApprovedMail($record->fresh()));
                        })
                        ->visible(fn ($record) => $record->status === 'pending'),

                    Action::make('reject')
                        ->label('Reject')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->form([
                            Textarea::make('admin_note')
                                ->label('Reason (shown to the user)')
                                ->required(),
                        ])
                        ->action(function (EnhancedVerification $record, array $data) {
                            $record->update([
                                'status' => 'rejected',
                                'admin_note' => $data['admin_note'],
                                'reviewed_by' => auth()->id(),
                                'reviewed_at' => now(),
                            ]);

                            $record->user->update(['enhanced_verification_status' => 'rejected']);

                            Mail::to($record->user->email)->send(new EnhancedVerificationRejectedMail($record->fresh()));
                        })
                        ->visible(fn ($record) => $record->status === 'pending'),

                    ViewAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
