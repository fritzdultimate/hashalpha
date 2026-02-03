<?php

namespace App\Filament\Pages;

use App\Jobs\SendQuickEmail;
use App\Models\User;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class QuickMail extends Page implements HasForms {
    use InteractsWithForms;

    protected static string|UnitEnum|null $navigationGroup = 'Mail System';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Envelope;
    protected string $view = 'filament.pages.quick-mail';

    public array $data = [];

    public function mount(): void {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema {
        return $schema
            ->statePath('data')
            ->schema([
                Select::make('users')
                    ->label('Select Users')
                    ->multiple()
                    ->searchable()
                    ->options(fn () => User::pluck('email', 'id')->toArray())
                    ->required(),

                TextInput::make('subject')
                    ->label('Email Subject')
                    ->required(),

                Textarea::make('content')
                    ->label('Email Content')
                    ->rows(6)
                    ->required(),
            ]);
    }

    public function send(): void {
        $data = $this->form->getState();

        $emails = User::whereIn('id', $data['users'])
            ->pluck('email')
            ->toArray();

        if (empty($emails)) {
            Notification::make()
                ->title('No Users Selected')
                ->body('Please select at least one user.')
                ->danger()
                ->send();
            return;
        }


        SendQuickEmail::dispatch($emails, $data['subject'], $data['content']);

        Notification::make()
            ->title('Email sent')
            ->body(count($emails) . ' users will receive the email.')
            ->success()
            ->send();

        $this->form->fill();

    }

}
