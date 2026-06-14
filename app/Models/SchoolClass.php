<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $fillable = ['name', 'level', 'major', 'academic_year_id', 'wali_kelas_id'];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function getFullNameAttribute(): string
    {
        return $this->level . ' ' . $this->name;
    }
}
