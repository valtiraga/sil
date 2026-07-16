<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    protected $fillable = [
        'course_id',
        'student_id',
        'progress',
        'final_grade',
        'enrolled_at',
    ];

    protected function casts(): array
    {
        return [
            'progress' => 'decimal:2',
            'final_grade' => 'decimal:2',
            'enrolled_at' => 'datetime',
        ];
    }

    // ─── Relationships ────────────────────────────────────

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
