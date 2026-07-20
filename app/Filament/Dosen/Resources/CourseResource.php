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

    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): ?string
    {
        return __('nav.group.learning');
    }

    public static function getNavigationLabel(): string
    {
        return __('nav.course');
    }

    public static function getModelLabel(): string
    {
        return __('nav.course.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('nav.course.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('course.section_info'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('course.name'))
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('subject_id')
                            ->label(__('common.subject'))
                            ->relationship('subject', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\Select::make('lecturer_id')
                            ->label(__('course.lecturer'))
                            ->relationship(
                                'lecturer',
                                'name',
                                fn ($query) => $query->where('role', 'dosen')
                            )
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\Select::make('status')
                            ->label(__('common.status'))
                            ->options([
                                'draft' => __('course.status_draft'),
                                'active' => __('course.status_active'),
                                'completed' => __('course.status_completed'),
                            ])
                            ->required()
                            ->default('draft'),

                        Forms\Components\DatePicker::make('start_date')
                            ->label(__('course.start_date')),

                        Forms\Components\DatePicker::make('end_date')
                            ->label(__('course.end_date'))
                            ->afterOrEqual('start_date'),

                        Forms\Components\Textarea::make('description')
                            ->label(__('common.description'))
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
                    ->label(__('course.name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('subject.name')
                    ->label(__('common.subject'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('lecturer.name')
                    ->label(__('course.lecturer_short'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label(__('common.status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'active' => 'success',
                        'completed' => 'info',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => __('course.status_draft'),
                        'active' => __('course.status_active'),
                        'completed' => __('course.status_completed'),
                    }),

                Tables\Columns\TextColumn::make('enrollments_count')
                    ->label(__('course.enrolled'))
                    ->counts('enrollments')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label(__('course.start'))
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_date')
                    ->label(__('course.end'))
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('common.status'))
                    ->options([
                        'draft' => __('course.status_draft'),
                        'active' => __('course.status_active'),
                        'completed' => __('course.status_completed'),
                    ]),

                Tables\Filters\SelectFilter::make('subject_id')
                    ->label(__('common.subject'))
                    ->relationship('subject', 'name'),

                Tables\Filters\SelectFilter::make('lecturer_id')
                    ->label(__('course.lecturer_short'))
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
