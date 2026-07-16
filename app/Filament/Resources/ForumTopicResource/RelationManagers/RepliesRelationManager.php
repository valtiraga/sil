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

    protected static ?string $title = 'Balasan';

    protected static ?string $modelLabel = 'Balasan';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Textarea::make('body')
                    ->label('Isi Balasan')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('attachment')
                    ->label('Lampiran')
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
                    ->label('Penulis'),

                Tables\Columns\TextColumn::make('body')
                    ->label('Isi Balasan')
                    ->limit(80),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
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
