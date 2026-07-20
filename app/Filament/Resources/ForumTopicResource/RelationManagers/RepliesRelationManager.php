<?php

namespace App\Filament\Resources\ForumTopicResource\RelationManagers;

use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class RepliesRelationManager extends RelationManager
{
    protected static string $relationship = 'replies';

    public static function getTitle(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): string
    {
        return __('forum.replies');
    }

    public static function getModelLabel(): string
    {
        return __('forum.reply');
    }

    public static function getPluralModelLabel(): string
    {
        return __('forum.replies');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Textarea::make('body')
                    ->label(__('forum.reply_body'))
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('attachment')
                    ->label(__('forum.attachment'))
                    ->directory('forum-attachments')
                    ->maxSize(5120)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('forum.author')),

                Tables\Columns\TextColumn::make('body')
                    ->label(__('forum.reply_body'))
                    ->limit(80),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('common.time'))
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at')
            ->actions([
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
