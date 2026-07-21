<?php

namespace App\Filament\Mahasiswa\Resources;

use App\Filament\Mahasiswa\Resources\MyCourseResource\Pages;
use App\Models\Course;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MyCourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-academic-cap';

    public static function getNavigationLabel(): string
    {
        return 'My Courses';
    }

    public static function getModelLabel(): string
    {
        return 'Course';
    }

    public static function getPluralModelLabel(): string
    {
        return 'My Courses';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('course.name')),
                Forms\Components\Textarea::make('description')
                    ->label(__('common.description')),
                Forms\Components\DatePicker::make('start_date')
                    ->label(__('course.start_date')),
                Forms\Components\DatePicker::make('end_date')
                    ->label(__('course.end_date')),
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
                    ->label('Dosen Pengampu')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label(__('common.status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'active' => 'success',
                        'completed' => 'info',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        // Only show courses where the current user is enrolled
        return parent::getEloquentQuery()->whereHas('enrollments', function ($query) {
            $query->whereHas('student', function ($q) {
                $q->where('user_id', auth()->id());
            });
        });
    }

    public static function getRelations(): array
    {
        return [
            // Can add relation managers here to show content later
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMyCourses::route('/'),
            'view' => Pages\ViewMyCourse::route('/{record}'),
        ];
    }
}
