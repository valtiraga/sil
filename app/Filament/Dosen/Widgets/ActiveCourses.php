<?php

namespace App\Filament\Dosen\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class ActiveCourses extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Course::query()
                    ->where('lecturer_id', Auth::id())
                    ->where('status', 'active')
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kelas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject.name')
                    ->label('Mata Kuliah'),
                Tables\Columns\TextColumn::make('enrollments_count')
                    ->label('Peserta')
                    ->counts('enrollments')
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Mulai')
                    ->date('d M Y'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Kelola')
                    ->icon('heroicon-m-arrow-right-circle')
                    ->url(fn (Course $record): string => \App\Filament\Dosen\Resources\CourseResource::getUrl('edit', ['record' => $record])),
            ])
            ->paginated(false)
            ->heading('Kelas Aktif Saya');
    }
}
