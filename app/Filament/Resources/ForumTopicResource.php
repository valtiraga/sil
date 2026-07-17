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

    protected static string | \UnitEnum | null $navigationGroup = 'Pembelajaran';

    protected static ?string $navigationLabel = 'Forum Diskusi';

    protected static ?string $modelLabel = 'Topik Forum';

    protected static ?string $pluralModelLabel = 'Forum Diskusi';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Topik Diskusi')
                    ->schema([
                        Forms\Components\Select::make('subject_id')
                            ->label('Mata Kuliah')
                            ->relationship('subject', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\TextInput::make('title')
                            ->label('Judul Topik')
                            ->required()
                            ->maxLength(500),

                        Forms\Components\Textarea::make('body')
                            ->label('Isi')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('is_pinned')
                            ->label('Sematkan (Pin)'),

                        Forms\Components\Toggle::make('is_locked')
                            ->label('Kunci Topik'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('subject.name')
                    ->label('Mata Kuliah')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pembuat')
                    ->sortable(),

                Tables\Columns\TextColumn::make('replies_count')
                    ->label('Balasan')
                    ->counts('replies')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('Views')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('is_pinned')
                    ->label('Pin')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_locked')
                    ->label('Locked')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('subject_id')
                    ->label('Mata Kuliah')
                    ->relationship('subject', 'name'),

                Tables\Filters\TernaryFilter::make('is_pinned')
                    ->label('Disematkan'),

                Tables\Filters\TernaryFilter::make('is_locked')
                    ->label('Dikunci'),
            ])
            ->actions([
                \Filament\Actions\Action::make('togglePin')
                    ->label(fn ($record) => $record->is_pinned ? 'Unpin' : 'Pin')
                    ->icon(fn ($record) => $record->is_pinned ? 'heroicon-o-x-mark' : 'heroicon-o-bookmark')
                    ->action(fn ($record) => $record->update(['is_pinned' => !$record->is_pinned]))
                    ->color('warning'),
                \Filament\Actions\Action::make('toggleLock')
                    ->label(fn ($record) => $record->is_locked ? 'Unlock' : 'Lock')
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
