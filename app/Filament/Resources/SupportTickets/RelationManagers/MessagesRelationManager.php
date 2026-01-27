<?php

namespace App\Filament\Resources\SupportTickets\RelationManagers;

use App\Filament\Resources\SupportTickets\SupportTicketResource;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MessagesRelationManager extends RelationManager
{
    protected static string $relationship = 'messages';

    protected static ?string $relatedResource = SupportTicketResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('message')
            ->columns([
                TextColumn::make('message')
                    ->wrap()
                    ->label('Message'),

                BadgeColumn::make('is_staff')
                    ->label('Sender')
                    ->formatStateUsing(fn ($state) => $state ? 'Support' : 'User')
                    ->colors([
                        'success' => true,
                        'gray' => false,
                    ]),

                TextColumn::make('created_at')
                    ->since(),
            ])
            ->headerActions([])
            ->recordActions([]);
    }
}
