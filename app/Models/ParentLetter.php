<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentLetter extends Model
{
    protected $fillable = [
        'student_id', 'generated_by', 'letter_number', 'reason',
        'meeting_date', 'meeting_time', 'status', 'pdf_path',
    ];

    protected function casts(): array
    {
        return [
            'meeting_date' => 'date',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
