<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id', 'class_id', 'nis', 'nisn', 'gender', 'birth_date', 'birth_place',
        'address', 'parent_name', 'parent_phone', 'parent_address', 'photo',
        'initial_points', 'current_points',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function violations()
    {
        return $this->hasMany(Violation::class);
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    public function counselings()
    {
        return $this->hasMany(Counseling::class);
    }

    public function schedules()
    {
        return $this->hasMany(CounselingSchedule::class);
    }

    public function pointHistories()
    {
        return $this->hasMany(PointHistory::class);
    }

    public function recalculatePoints(): void
    {
        $totalDeducted = $this->violations()->sum('points_deducted');
        $totalAdded = $this->achievements()->sum('points_added');
        $this->current_points = $this->initial_points - $totalDeducted + $totalAdded;
        $this->save();
    }

    public function getGenderLabelAttribute(): string
    {
        return $this->gender === 'L' ? 'Laki-laki' : 'Perempuan';
    }
}
