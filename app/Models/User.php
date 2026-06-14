<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'avatar', 'is_active',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Role checkers
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isGuruBK(): bool { return $this->role === 'guru_bk'; }
    public function isWaliKelas(): bool { return $this->role === 'wali_kelas'; }
    public function isSiswa(): bool { return $this->role === 'siswa'; }
    public function isKepsek(): bool { return $this->role === 'kepsek'; }

    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles);
    }

    // Relationships
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function waliKelasClasses()
    {
        return $this->hasMany(SchoolClass::class, 'wali_kelas_id');
    }

    public function counselingsAsCounselor()
    {
        return $this->hasMany(Counseling::class, 'counselor_id');
    }

    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Administrator',
            'guru_bk' => 'Guru BK',
            'wali_kelas' => 'Wali Kelas',
            'siswa' => 'Siswa',
            'kepsek' => 'Kepala Sekolah',
            default => 'Unknown',
        };
    }
}
