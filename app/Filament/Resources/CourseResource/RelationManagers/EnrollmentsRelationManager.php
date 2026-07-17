<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use App\Models\Student;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class EnrollmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'enrollments';

    protected static ?string $title = 'Mahasiswa Terdaftar';

    protected static ?string $modelLabel = 'Mahasiswa';
    
    protected static ?string $pluralModelLabel = 'Mahasiswa';

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
                    ->label('NIM')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('student.full_name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('student.department.name')
                    ->label('Jurusan')
                    ->sortable(),

                Tables\Columns\TextColumn::make('enrolled_at')
                    ->label('Tgl Enroll')
                    ->dateTime('d M Y')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('progress')
                    ->label('Progress (%)')
                    ->numeric()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('final_grade')
                    ->label('Nilai Akhir')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                \Filament\Actions\Action::make('enroll')
                    ->label('Enroll Mahasiswa')
                    ->modalHeading('Enroll Mahasiswa ke Course')
                    ->form([
                        Forms\Components\Select::make('student_id')
                            ->label('Mahasiswa')
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
                    ->label('Hapus Akses')
                    ->modalHeading('Hapus Enrollment Mahasiswa'),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
