<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ForumTopicResource\Pages;
use App\Filament\Resources\ForumTopicResource\RelationManagers;
use App\Models\ForumTopic;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;

class ForumTopicResource extends Resource
{
    protected static ?string $model = ForumTopic::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?int $navigationSort = 7;

    public static function getNavigationGroup(): ?string
    {
        return __('nav.group.learning');
    }

    public static function getNavigationLabel(): string
    {
        return __('nav.forum');
    }

    public static function getModelLabel(): string
    {
        return __('nav.forum.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('nav.forum.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('forum.section_topic'))
                    ->schema([
                        Forms\Components\Select::make('subject_id')
                            ->label(__('common.subject'))
                            ->relationship('subject', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\TextInput::make('title')
                            ->label(__('forum.title'))
                            ->required()
                            ->maxLength(500),

                        Forms\Components\Textarea::make('body')
                            ->label(__('forum.body'))
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('is_pinned')
                            ->label(__('forum.pin')),

                        Forms\Components\Toggle::make('is_locked')
                            ->label(__('forum.lock')),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('forum.title_short'))
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('subject.name')
                    ->label(__('common.subject'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('common.creator'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('replies_count')
                    ->label(__('forum.replies'))
                    ->counts('replies')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('views_count')
                    ->label(__('forum.views'))
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('is_pinned')
                    ->label(__('forum.pin_label'))
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_locked')
                    ->label(__('forum.locked'))
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('common.created_at'))
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('subject_id')
                    ->label(__('common.subject'))
                    ->relationship('subject', 'name'),

                Tables\Filters\TernaryFilter::make('is_pinned')
                    ->label(__('forum.pinned')),

                Tables\Filters\TernaryFilter::make('is_locked')
                    ->label(__('forum.locked')),
            ])
            ->actions([
                \Filament\Actions\Action::make('togglePin')
                    ->label(fn ($record) => $record->is_pinned ? __('forum.unpin') : __('forum.pin_action'))
                    ->icon(fn ($record) => $record->is_pinned ? 'heroicon-o-x-mark' : 'heroicon-o-bookmark')
                    ->action(fn ($record) => $record->update(['is_pinned' => !$record->is_pinned]))
                    ->color('warning'),
                \Filament\Actions\Action::make('toggleLock')
                    ->label(fn ($record) => $record->is_locked ? __('forum.unlock') : __('forum.lock_action'))
                    ->icon(fn ($record) => $record->is_locked ? 'heroicon-o-lock-open' : 'heroicon-o-lock-closed')
                    ->action(fn ($record) => $record->update(['is_locked' => !$record->is_locked]))
                    ->color('danger'),
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\RepliesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListForumTopics::route('/'),
            'edit' => Pages\EditForumTopic::route('/{record}/edit'),
        ];
    }
}
