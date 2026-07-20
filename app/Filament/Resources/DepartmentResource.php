<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartmentResource\Pages;
use App\Models\Department;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-building-office';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('nav.group.data_master');
    }

    public static function getNavigationLabel(): string
    {
        return __('nav.department');
    }

    public static function getModelLabel(): string
    {
        return __('nav.department.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('nav.department.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('dept.section_info'))
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label(__('dept.code'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20)
                            ->placeholder(__('dept.code_placeholder')),

                        Forms\Components\TextInput::make('name')
                            ->label(__('dept.name'))
                            ->required()
                            ->minLength(3)
                            ->maxLength(255)
                            ->placeholder(__('dept.name_placeholder')),

                        Forms\Components\TextInput::make('head_of_department')
                            ->label(__('dept.head'))
                            ->maxLength(255)
                            ->placeholder(__('dept.head_placeholder')),

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
                    ->label(__('dept.name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('head_of_department')
                    ->label(__('dept.head'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('students_count')
                    ->label(__('dept.student_count'))
                    ->counts('students')
                    ->sortable(),

                Tables\Columns\TextColumn::make('subjects_count')
                    ->label(__('dept.subject_count'))
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
            'index' => Pages\ListDepartments::route('/'),
            'create' => Pages\CreateDepartment::route('/create'),
            'edit' => Pages\EditDepartment::route('/{record}/edit'),
        ];
    }
}
