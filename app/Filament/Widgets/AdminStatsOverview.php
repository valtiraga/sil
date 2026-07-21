<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\StudyProgram;
use App\Models\Course;
use App\Models\Student;

class AdminStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Mahasiswa', Student::count())
                ->description('Total mahasiswa terdaftar')
                ->descriptionIcon('heroicon-m-user-group')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Total Dosen', User::role('dosen')->count())
                ->description('Total dosen aktif')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info'),
            Stat::make('Program Studi', StudyProgram::count())
                ->description('Jumlah prodi saat ini')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('warning'),
            Stat::make('Total Course', Course::count())
                ->description('Jumlah kelas dibuat')
                ->descriptionIcon('heroicon-m-book-open')
                ->chart([1, 4, 3, 5, 2, 7, 8])
                ->color('primary'),
        ];
    }
}
