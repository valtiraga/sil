<?php

namespace App\Filament\Dosen\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\ForumTopic;
use Illuminate\Support\Facades\Auth;

class DosenStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $dosenId = Auth::id();
        
        $myCoursesCount = Course::where('lecturer_id', $dosenId)->count();
        $activeCoursesCount = Course::where('lecturer_id', $dosenId)->where('status', 'active')->count();
        $totalStudents = Enrollment::whereHas('course', function ($q) use ($dosenId) {
            $q->where('lecturer_id', $dosenId);
        })->count();
        
        return [
            Stat::make('Total Kelas Saya', $myCoursesCount)
                ->description($activeCoursesCount . ' kelas berstatus aktif')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('primary'),
            Stat::make('Mahasiswa Diajar', $totalStudents)
                ->description('Total mahasiswa terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            Stat::make('Topik Forum', ForumTopic::where('author_id', $dosenId)->count())
                ->description('Topik diskusi dibuat')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('info'),
        ];
    }
}
