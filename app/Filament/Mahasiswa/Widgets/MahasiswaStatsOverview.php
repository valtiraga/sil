<?php

namespace App\Filament\Mahasiswa\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class MahasiswaStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            return [];
        }

        $enrolledCount = Enrollment::where('student_id', $student->id)->count();
        $completedCount = Enrollment::where('student_id', $student->id)->where('progress', '>=', 100)->count();
        $avgProgress = Enrollment::where('student_id', $student->id)->avg('progress') ?? 0;

        return [
            Stat::make('Kelas Diikuti', $enrolledCount)
                ->description('Total course saat ini')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('primary'),
            Stat::make('Kelas Selesai', $completedCount)
                ->description('Progres 100%')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
            Stat::make('Rata-rata Progres', number_format($avgProgress, 1) . '%')
                ->description('Dari seluruh kelas aktif')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info'),
        ];
    }
}
