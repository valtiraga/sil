<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubjectResource\Pages;
use App\Models\Subject;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SubjectResource extends Resource
{
    protected static ?string $model = Subject::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-book-open';

    protected static string | \UnitEnum | null $navigationGroup = 'Data Master';

    protected static ?string $navigationLabel = 'Mata Kuliah';

    protected static ?string $modelLabel = 'Mata Kuliah';

    protected static ?string $pluralModelLabel = 'Mata Kuliah';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make('Informasi Mata Kuliah')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('Kode MK')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20),

                        Forms\Components\TextInput::make('name')
                            ->label('Nama Mata Kuliah')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('department_id')
                            ->label('Jurusan')
                            ->relationship('department', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\TextInput::make('credits')
                            ->label('SKS')
                            ->numeric()
                            ->required()
                            ->default(2)
                            ->minValue(1)
                            ->maxValue(6),

                        Forms\Components\TextInput::make('semester')
                            ->label('Semester')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->maxValue(8),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Mata Kuliah')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('department.name')
                    ->label('Jurusan')
                    ->sortable(),

                Tables\Columns\TextColumn::make('credits')
                    ->label('SKS')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('semester')
                    ->label('Semester')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('courses_count')
                    ->label('Jml Course')
                    ->counts('courses')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('department_id')
                    ->label('Jurusan')
                    ->relationship('department', 'name'),

                Tables\Filters\SelectFilter::make('semester')
                    ->label('Semester')
                    ->options(array_combine(range(1, 8), range(1, 8))),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubjects::route('/'),
            'create' => Pages\CreateSubject::route('/create'),
            'edit' => Pages\EditSubject::route('/{record}/edit'),
        ];
    }
}
