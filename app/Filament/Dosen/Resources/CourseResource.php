<?php

namespace App\Filament\Dosen\Resources;

use App\Filament\Dosen\Resources\CourseResource\Pages;
use App\Filament\Dosen\Resources\CourseResource\RelationManagers;
use App\Models\Course;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-computer-desktop';

    protected static string | \UnitEnum | null $navigationGroup = 'Pembelajaran';

    protected static ?string $navigationLabel = 'Course';

    protected static ?string $modelLabel = 'Course';

    protected static ?string $pluralModelLabel = 'Course';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informasi Course')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Course')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('subject_id')
                            ->label('Mata Kuliah')
                            ->relationship('subject', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\Select::make('lecturer_id')
                            ->label('Dosen Pengampu')
                            ->relationship(
                                'lecturer',
                                'name',
                                fn ($query) => $query->where('role', 'dosen')
                            )
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'active' => 'Aktif',
                                'completed' => 'Selesai',
                            ])
                            ->required()
                            ->default('draft'),

                        Forms\Components\DatePicker::make('start_date')
                            ->label('Tanggal Mulai'),

                        Forms\Components\DatePicker::make('end_date')
                            ->label('Tanggal Selesai')
                            ->afterOrEqual('start_date'),

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
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Course')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('subject.name')
                    ->label('Mata Kuliah')
                    ->sortable(),

                Tables\Columns\TextColumn::make('lecturer.name')
                    ->label('Dosen')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'active' => 'success',
                        'completed' => 'info',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Draft',
                        'active' => 'Aktif',
                        'completed' => 'Selesai',
                    }),

                Tables\Columns\TextColumn::make('enrollments_count')
                    ->label('Enrolled')
                    ->counts('enrollments')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('Mulai')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_date')
                    ->label('Selesai')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'active' => 'Aktif',
                        'completed' => 'Selesai',
                    ]),

                Tables\Filters\SelectFilter::make('subject_id')
                    ->label('Mata Kuliah')
                    ->relationship('subject', 'name'),

                Tables\Filters\SelectFilter::make('lecturer_id')
                    ->label('Dosen')
                    ->relationship('lecturer', 'name'),
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

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->where('lecturer_id', auth()->id());
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ContentsRelationManager::class,
            RelationManagers\EnrollmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
