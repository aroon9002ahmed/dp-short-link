<?php

namespace App\Filament\Resources\Links\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('short_code')
                    ->label('Short Link')
                    ->readOnly()
                    ->dehydrated(false)
                    ->hiddenOn('create')
                    ->formatStateUsing(fn($state) => $state ? url('/' . $state) : null)
                    ->suffixAction(
                        Action::make('copyShortLink')
                            ->icon(\Filament\Support\Icons\Heroicon::ClipboardDocumentList)
                            ->color('gray')
                            ->alpineClickHandler("
                                const input = \$el.closest('.fi-input-wrp').querySelector('input');
                                input.select();
                                document.execCommand('copy');
                                \$tooltip('Copied!', { theme: \$store.theme, timeout: 2000 });
                            ")
                    ),
                TextInput::make('title')
                    ->label('Title')
                    ->helperText('Add description for the link')
                    ->maxLength(255)
                    ->autofocus(),
                Placeholder::make('original_url_display')
                    ->label('Original URL')
                    ->content(fn($record) => $record?->original_url)
                    ->visibleOn('edit'),
                Textarea::make('original_url')
                    ->label('Original URL')
                    ->required()
                    ->hiddenOn('edit')
                    ->rules([
                        'url',
                        'active_url',
                        new class implements \Illuminate\Contracts\Validation\ValidationRule {
                            public function validate(string $attribute, mixed $value, \Closure $fail): void
                            {
                                $query = \App\Models\Link::where('original_url', $value);

                                // Exclude the current record when editing
                                if ($recordId = request()->route('record')) {
                                    $query->where('id', '!=', $recordId);
                                }

                                $existingLink = $query->first();

                                if ($existingLink) {
                                    $shortLink = url('/' . $existingLink->short_code);
                                    $viewUrl = \App\Filament\Resources\Links\LinkResource::getUrl('view', ['record' => $existingLink]);

                                    \Filament\Notifications\Notification::make()
                                        ->danger()
                                        ->title('Duplicate URL detected!')
                                        ->body("This URL already has a short link: **{$shortLink}**")
                                        ->actions([
                                            Action::make('view_existing')
                                                ->label('View Existing Link')
                                                ->url($viewUrl)
                                                ->button(),
                                        ])
                                        ->persistent()
                                        ->send();

                                    $fail('This URL already has a short link.');
                                }
                            }
                        },
                    ]),
                DateTimePicker::make('expires_at'),
                Toggle::make('is_active')
                    ->label('Is Active')
                    ->default(true)
                    ->required(),
                TextEntry::make('creator.name')
                    ->label('Created By')
                    ->default('Admin')
                    ->hiddenOn('create'),
                TextEntry::make('clicks')
                    ->label('Clicks')
                    ->default(0)
                    ->hiddenOn('create'),

            ]);
    }
}
