<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ContentsRelationManager extends RelationManager
{
    protected static string $relationship = 'contents';

    protected static ?string $title = 'Konten Course';

    protected static ?string $modelLabel = 'Konten';

    protected static ?string $pluralModelLabel = 'Konten';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('type')
                    ->label('Tipe')
                    ->options([
                        'pdf' => 'PDF / Modul',
                        'video' => 'Video',
                    ])
                    ->required()
                    ->reactive(),

                Forms\Components\FileUpload::make('file_path')
                    ->label('File')
                    ->required()
                    ->directory('course-contents')
                    ->maxSize(51200)
                    ->acceptedFileTypes(fn ($get) => match ($get('type')) {
                        'pdf' => ['application/pdf'],
                        'video' => ['video/mp4', 'video/webm', 'video/x-matroska'],
                        default => ['application/pdf', 'video/mp4', 'video/webm'],
                    })
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0),

                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(2)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pdf' => 'info',
                        'video' => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pdf' => 'PDF',
                        'video' => 'Video',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ditambahkan')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->headerActions([
                \Filament\Actions\CreateAction::make(),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
