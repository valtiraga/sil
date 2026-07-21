<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudyProgramResource\Pages;
use App\Models\StudyProgram;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;

class StudyProgramResource extends Resource
{
    protected static ?string $model = StudyProgram::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-building-office';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('nav.group.data_master');
    }

    public static function getNavigationLabel(): string
    {
        return __('nav.study_program');
    }

    public static function getModelLabel(): string
    {
        return __('nav.study_program.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('nav.study_program.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('study_program.section_info'))
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label(__('study_program.code'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20)
                            ->placeholder(__('study_program.code_placeholder')),

                        Forms\Components\TextInput::make('name')
                            ->label(__('study_program.name'))
                            ->required()
                            ->minLength(3)
                            ->maxLength(255)
                            ->placeholder(__('study_program.name_placeholder')),

                        Forms\Components\TextInput::make('head_of_study_program')
                            ->label(__('study_program.head'))
                            ->maxLength(255)
                            ->placeholder(__('study_program.head_placeholder')),

                        Forms\Components\Toggle::make('is_active')
                            ->label(__('common.active_status'))
                            ->default(true),
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
                    ->label(__('study_program.name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('head_of_study_program')
                    ->label(__('study_program.head'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('students_count')
                    ->label(__('study_program.student_count'))
                    ->counts('students')
                    ->sortable(),

                Tables\Columns\TextColumn::make('subjects_count')
                    ->label(__('study_program.subject_count'))
                    ->counts('subjects')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('common.active'))
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('common.created_at'))
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudyPrograms::route('/'),
            'create' => Pages\CreateStudyProgram::route('/create'),
            'edit' => Pages\EditStudyProgram::route('/{record}/edit'),
        ];
    }
}
