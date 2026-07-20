<?php

namespace App\Filament\Dosen\Resources\CourseResource\RelationManagers;

use App\Models\Student;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class EnrollmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'enrollments';

    public static function getTitle(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): string
    {
        return __('course.enrolled_students');
    }

    public static function getModelLabel(): string
    {
        return __('course.student');
    }

    public static function getPluralModelLabel(): string
    {
        return __('course.students');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                //
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.nim')
                    ->label(__('student.nim'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('student.full_name')
                    ->label(__('common.full_name'))
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('student.department.name')
                    ->label(__('common.department'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('enrolled_at')
                    ->label(__('course.enroll_date'))
                    ->dateTime('d M Y')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('progress')
                    ->label(__('course.progress'))
                    ->numeric()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('final_grade')
                    ->label(__('course.final_grade'))
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                \Filament\Actions\Action::make('enroll')
                    ->label(__('course.enroll_student'))
                    ->modalHeading(__('course.enroll_student_modal'))
                    ->form([
                        Forms\Components\Select::make('student_id')
                            ->label(__('course.student'))
                            ->multiple()
                            ->options(function (RelationManager $livewire) {
                                $enrolledIds = $livewire->getOwnerRecord()->enrollments()->pluck('student_id')->toArray();
                                return Student::whereNotIn('id', $enrolledIds)
                                    ->pluck('full_name', 'id');
                            })
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function (array $data, RelationManager $livewire) {
                        $studentIds = $data['student_id'];
                        foreach ($studentIds as $studentId) {
                            $livewire->getOwnerRecord()->enrollments()->create([
                                'student_id' => $studentId,
                                'enrolled_at' => now(),
                                'progress' => 0,
                            ]);
                        }
                    })
            ])
            ->actions([
                \Filament\Actions\DeleteAction::make()
                    ->label(__('course.remove_access'))
                    ->modalHeading(__('course.remove_enrollment_modal')),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
