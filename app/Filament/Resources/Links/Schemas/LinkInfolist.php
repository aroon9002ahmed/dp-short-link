<?php

namespace App\Filament\Resources\Links\Schemas;

use Filament\Actions\Action;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LinkInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    TextEntry::make('short_code')
                        ->label('Short Link')
                        ->formatStateUsing(fn($state) => $state ? url('/' . $state) : null)
                        ->copyable()
                        ->copyableState(fn($state) => $state ? url('/' . $state) : null)
                        ->copyMessage('Short link copied!')
                        ->suffixAction(
                            Action::make('copyShortLink')
                                ->icon(\Filament\Support\Icons\Heroicon::ClipboardDocumentList)
                                ->color('gray')
                                ->alpineClickHandler(
                                    fn($record) =>
                                    "const el = document.createElement('textarea'); " .
                                        "el.value = " . \Illuminate\Support\Js::from(url('/' . $record->short_code)) . "; " .
                                        "el.style.position = 'fixed'; el.style.opacity = '0'; " .
                                        "document.body.appendChild(el); el.select(); document.execCommand('copy'); " .
                                        "document.body.removeChild(el); " .
                                        "\$tooltip('Copied!', { theme: \$store.theme, timeout: 2000 });"
                                )
                        ),
                ]),
                TextEntry::make('title')
                    ->label('Title')
                    ->default('-'),
                TextEntry::make('original_url')
                    ->columnSpanFull(),
                TextEntry::make('qr_code')
                    ->label('QR Code')
                    ->html()
                    ->default('qr')
                    ->formatStateUsing(function ($state, $record) {
                        return \LaraZeus\Qr\Facades\Qr::render(
                            data: url(env('APP_URL') . '/' . $record->short_code),
                            options: array_merge(
                                $record->qr_options ?? \LaraZeus\Qr\Facades\Qr::getDefaultOptions(),
                                ['type' => 'svg']
                            )
                        );
                    })
                    ->columnSpanFull(),
                TextEntry::make('clicks')
                    ->numeric(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('expires_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('creator.name')
                    ->label('Created by')
                    ->statePath('creator.name'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
