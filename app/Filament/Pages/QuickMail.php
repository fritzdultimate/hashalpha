<?php

namespace App\Filament\Pages;

use App\Jobs\SendQuickEmail;
use App\Models\User;
use BackedEnum;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class QuickMail extends Page implements HasForms {
    use InteractsWithForms;

    protected static string|UnitEnum|null $navigationGroup = 'Mail System';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Envelope;
    protected static ?string $navigationLabel = 'Send Custom Email';
    protected static ?string $title = 'Send Custom Email';
    protected string $view = 'filament.pages.quick-mail';

    /**
     * HTML tags allowed to survive from the rich text editor into the
     * outgoing email. This strips anything unexpected (e.g. <script>,
     * <style>, <iframe>) while preserving normal formatting.
     */
    protected const ALLOWED_BODY_TAGS = '<p><br><strong><b><em><i><u><s><ul><ol><li><a><h1><h2><h3><h4><blockquote><img><span><table><thead><tbody><tr><td><th><hr><code><pre>';

    public array $data = [];

    public function mount(): void {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema {
        return $schema
            ->statePath('data')
            ->schema([
                Section::make('Recipients')
                    ->description('Pick registered users and/or type any other email addresses. You can use both at once.')
                    ->schema([
                        Select::make('user_ids')
                            ->label('Registered Users')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->options(fn () => User::query()
                                ->orderBy('name')
                                ->get()
                                ->mapWithKeys(fn (User $user) => [
                                    $user->id => trim(($user->name ?: $user->email) . ' <' . $user->email . '>'),
                                ])
                                ->toArray()),

                        TagsInput::make('custom_emails')
                            ->label('Additional Email Addresses')
                            ->helperText('For recipients who are not registered users. Press space, comma or enter after each address.')
                            ->placeholder('name@example.com')
                            ->splitKeys([',', ' ', 'Tab', 'Enter']),
                    ])
                    ->columns(1),

                Section::make('Message')
                    ->schema([
                        TextInput::make('subject')
                            ->label('Email Subject')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        RichEditor::make('content')
                            ->label('Email Content')
                            ->required()
                            ->helperText('This message is automatically placed inside the official platform email design (logo, header and footer), so it arrives looking like it came straight from the platform.')
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'strike', 'link',
                                'bulletList', 'orderedList', 'blockquote',
                                'h2', 'h3', 'redo', 'undo',
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ]);
    }

    public function send(): void {
        $data = $this->form->getState();

        $userEmails = User::query()
            ->whereIn('id', $data['user_ids'] ?? [])
            ->pluck('email')
            ->all();

        $customEmails = collect($data['custom_emails'] ?? [])
            ->map(fn ($email) => trim((string) $email))
            ->filter()
            ->values();

        $invalidEmails = $customEmails
            ->reject(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL) !== false)
            ->values();

        if ($invalidEmails->isNotEmpty()) {
            Notification::make()
                ->title('Invalid Email Address')
                ->body('These entries are not valid email addresses: ' . $invalidEmails->implode(', '))
                ->danger()
                ->send();
            return;
        }

        $emails = collect($userEmails)
            ->merge($customEmails)
            ->filter()
            ->unique(fn ($email) => strtolower($email))
            ->values()
            ->all();

        if (empty($emails)) {
            Notification::make()
                ->title('No Recipients Selected')
                ->body('Select at least one registered user or enter an email address.')
                ->danger()
                ->send();
            return;
        }

        $subject = trim((string) ($data['subject'] ?? ''));
        $content = strip_tags((string) ($data['content'] ?? ''), self::ALLOWED_BODY_TAGS);

        if ($content === '') {
            Notification::make()
                ->title('Email Content Required')
                ->body('Please write a message before sending.')
                ->danger()
                ->send();
            return;
        }

        SendQuickEmail::dispatch($emails, $subject, $content);

        Notification::make()
            ->title('Email Queued')
            ->body(count($emails) . ' recipient(s) will receive the email shortly.')
            ->success()
            ->send();

        $this->form->fill([
            'user_ids' => [],
            'custom_emails' => [],
            'subject' => $data['subject'] ?? '',
            'content' => $data['content'] ?? '',
        ]);
    }
}
