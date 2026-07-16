<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = [
        'code',
        'name',
        'head_of_department',
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
        return $this->hasMany(Student::class, 'department_id');
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class, 'department_id');
    }
}
