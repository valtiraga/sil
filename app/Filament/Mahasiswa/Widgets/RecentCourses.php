<?php

namespace App\Filament\Mahasiswa\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class RecentCourses extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $studentId = Auth::user()->student?->id;

        return $table
            ->query(
                Enrollment::query()
                    ->where('student_id', $studentId)
                    ->latest('updated_at')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('course.name')
                    ->label('Nama Kelas'),
                Tables\Columns\TextColumn::make('course.lecturer.name')
                    ->label('Dosen Pengampu'),
                Tables\Columns\TextColumn::make('progress')
                    ->label('Progres')
                    ->badge()
                    ->color(fn (string $state): string => $state >= 100 ? 'success' : 'warning')
                    ->formatStateUsing(fn (string $state): string => $state . '%'),
                Tables\Columns\TextColumn::make('enrolled_at')
                    ->label('Bergabung Sejak')
                    ->dateTime('d M Y'),
            ])
            ->actions([
                Tables\Actions\Action::make('buka')
                    ->label('Buka Kelas')
                    ->icon('heroicon-m-arrow-right-circle')
                    ->url(fn (Enrollment $record): string => \App\Filament\Mahasiswa\Resources\MyCourseResource::getUrl('view', ['record' => $record->course_id])),
            ])
            ->paginated(false)
            ->heading('Akses Kelas Terakhir');
    }
}
