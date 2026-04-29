<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Links\LinkResource;
use App\Models\Link;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LinkWidget extends TableWidget
{
    protected static ?string $title = 'Links list';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => Link::query())
            ->heading('Links list')
            ->columns([
                TextColumn::make('short_code')
                    ->label('Short Code')
                    ->searchable(),
                TextColumn::make('clicks')
                    ->label('Click Count')
                    ->searchable(),
                TextColumn::make('creator.name')
                    ->label('Created by')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('new_link')
                    ->url(LinkResource::getUrl('create'))
                    ->label('Create New Link')
                    ->color('primary')
            ])
            ->recordActions([
                ViewAction::make()
                    ->url(fn(Link $record): string => LinkResource::getUrl('view', ['record' => $record])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    protected int|string|array $columnSpan = 'full';
}
