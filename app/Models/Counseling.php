<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Counseling extends Model
{
    protected $fillable = [
        'student_id', 'counselor_id', 'category_id', 'date', 'problem',
        'solution', 'follow_up', 'status', 'is_confidential',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'is_confidential' => 'boolean',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

    public function category()
    {
        return $this->belongsTo(CounselingCategory::class, 'category_id');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'ongoing' => '<span class="badge bg-info">Ongoing</span>',
            'completed' => '<span class="badge bg-success">Completed</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}
