<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Models\Student;
use App\Models\User;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): ?string
    {
        return __('nav.group.data_master');
    }

    public static function getNavigationLabel(): string
    {
        return __('nav.student');
    }

    public static function getModelLabel(): string
    {
        return __('nav.student.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('nav.student.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('student.section_info'))
                    ->schema([
                        Forms\Components\TextInput::make('nim')
                            ->label(__('student.nim'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20),

                        Forms\Components\TextInput::make('full_name')
                            ->label(__('common.full_name'))
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label(__('common.email'))
                            ->email()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('phone')
                            ->label(__('student.phone'))
                            ->tel()
                            ->maxLength(20),

                        Forms\Components\Select::make('department_id')
                            ->label(__('common.department'))
                            ->relationship('department', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\TextInput::make('enrollment_year')
                            ->label(__('student.enrollment_year'))
                            ->numeric()
                            ->required()
                            ->default(date('Y'))
                            ->minValue(2000)
                            ->maxValue(2099),

                        Forms\Components\TextInput::make('current_semester')
                            ->label(__('student.active_semester'))
                            ->numeric()
                            ->required()
                            ->default(1)
                            ->minValue(1)
                            ->maxValue(14),

                        Forms\Components\Select::make('status')
                            ->label(__('common.status'))
                            ->options([
                                'active' => __('student.status_active'),
                                'on_leave' => __('student.status_leave'),
                                'graduated' => __('student.status_graduated'),
                                'dropped_out' => __('student.status_dropped'),
                            ])
                            ->required()
                            ->default('active'),

                        Forms\Components\FileUpload::make('profile_photo')
                            ->label(__('student.profile_photo'))
                            ->image()
                            ->directory('students/photos')
                            ->maxSize(2048)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nim')
                    ->label(__('student.nim'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('full_name')
                    ->label(__('common.name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('department.name')
                    ->label(__('common.department'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('enrollment_year')
                    ->label(__('student.enrollment_year'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('current_semester')
                    ->label(__('common.semester'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label(__('common.status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'on_leave' => 'warning',
                        'graduated' => 'info',
                        'dropped_out' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => __('student.status_active'),
                        'on_leave' => __('student.status_leave'),
                        'graduated' => __('student.status_graduated'),
                        'dropped_out' => __('student.status_dropped'),
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('common.created_at'))
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('department_id')
                    ->label(__('common.department'))
                    ->relationship('department', 'name'),

                Tables\Filters\SelectFilter::make('status')
                    ->label(__('common.status'))
                    ->options([
                        'active' => __('student.status_active'),
                        'on_leave' => __('student.status_leave'),
                        'graduated' => __('student.status_graduated'),
                        'dropped_out' => __('student.status_dropped'),
                    ]),

                Tables\Filters\SelectFilter::make('enrollment_year')
                    ->label(__('student.enrollment_year'))
                    ->options(fn () => Student::query()
                        ->distinct()
                        ->orderByDesc('enrollment_year')
                        ->pluck('enrollment_year', 'enrollment_year')
                        ->toArray()
                    ),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
