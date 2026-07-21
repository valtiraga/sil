<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudyProgram extends Model
{
    protected $fillable = [
        'code',
        'name',
        'head_of_study_program',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // ─── Relationships ────────────────────────────────────

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'study_program_id');
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class, 'study_program_id');
    }
}
