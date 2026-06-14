<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounselingSchedule extends Model
{
    protected $fillable = [
        'student_id', 'counselor_id', 'date', 'time_start', 'time_end',
        'status', 'notes', 'rejection_reason', 'requested_by',
    ];

    protected function casts(): array
    {
        return ['date' => 'date'];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }
}
