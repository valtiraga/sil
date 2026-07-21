<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubjectResource\Pages;
use App\Models\Subject;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;

class SubjectResource extends Resource
{
    protected static ?string $model = Subject::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-book-open';

    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): ?string
    {
        return __('nav.group.data_master');
    }

    public static function getNavigationLabel(): string
    {
        return __('nav.subject');
    }

    public static function getModelLabel(): string
    {
        return __('nav.subject.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('nav.subject.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('subject.section_info'))
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label(__('subject.code'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20),

                        Forms\Components\TextInput::make('name')
                            ->label(__('subject.name'))
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('study_program_id')
                            ->label(__('common.study_program'))
                            ->relationship('studyProgram', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\TextInput::make('credits')
                            ->label(__('subject.credits'))
                            ->numeric()
                            ->required()
                            ->default(2)
                            ->minValue(1)
                            ->maxValue(6),

                        Forms\Components\TextInput::make('semester')
                            ->label(__('common.semester'))
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->maxValue(8),

                        Forms\Components\Toggle::make('is_active')
                            ->label(__('common.active_status'))
                            ->default(true),

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
                Tables\Columns\TextColumn::make('code')
                    ->label(__('common.code'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('subject.name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('studyProgram.name')
                    ->label(__('common.study_program'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('credits')
                    ->label(__('subject.credits'))
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('semester')
                    ->label(__('common.semester'))
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('courses_count')
                    ->label(__('subject.course_count'))
                    ->counts('courses')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('common.active'))
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('study_program_id')
                    ->label(__('common.study_program'))
                    ->relationship('studyProgram', 'name'),

                Tables\Filters\SelectFilter::make('semester')
                    ->label(__('common.semester'))
                    ->options(array_combine(range(1, 8), range(1, 8))),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label(__('common.active_status')),
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
