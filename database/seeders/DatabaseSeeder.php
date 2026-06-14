<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\AcademicYear;
use App\Models\SchoolSetting;
use App\Models\CounselingCategory;
use App\Models\ViolationType;
use App\Models\AchievementType;
use App\Models\Counseling;
use App\Models\Violation;
use App\Models\Achievement;
use App\Models\PointHistory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // School Settings
        $settings = [
            'school_name' => 'SMK Negeri 1 Nusantara',
            'school_address' => 'Jl. Pendidikan No. 1, Kota Nusantara',
            'school_phone' => '(021) 1234567',
            'school_email' => 'info@smkn1nusantara.sch.id',
            'school_logo' => '',
            'principal_name' => 'Drs. Budi Santoso, M.Pd',
            'principal_nip' => '196501011990031001',
            'wa_api_token' => '',
            'wa_api_url' => 'https://api.fonnte.com/send',
            'initial_student_points' => '100',
            'warning_point_threshold' => '50',
            'critical_point_threshold' => '25',
        ];
        foreach ($settings as $key => $value) {
            SchoolSetting::setValue($key, $value);
        }

        // Academic Year
        $ay = AcademicYear::create([
            'year' => '2025/2026',
            'semester' => 'genap',
            'is_active' => true,
        ]);

        // Counseling Categories
        $categories = [
            ['name' => 'Belajar', 'color' => '#6366F1', 'icon' => 'bi-book'],
            ['name' => 'Pribadi', 'color' => '#8B5CF6', 'icon' => 'bi-person'],
            ['name' => 'Sosial', 'color' => '#EC4899', 'icon' => 'bi-people'],
            ['name' => 'Karier', 'color' => '#F59E0B', 'icon' => 'bi-briefcase'],
        ];
        foreach ($categories as $cat) {
            CounselingCategory::create($cat);
        }

        // Violation Types
        $violationTypes = [
            ['name' => 'Terlambat masuk sekolah', 'category' => 'ringan', 'points' => 5],
            ['name' => 'Tidak memakai seragam lengkap', 'category' => 'ringan', 'points' => 5],
            ['name' => 'Tidak mengerjakan tugas', 'category' => 'ringan', 'points' => 5],
            ['name' => 'Membolos pelajaran', 'category' => 'sedang', 'points' => 10],
            ['name' => 'Membawa HP saat pelajaran', 'category' => 'sedang', 'points' => 10],
            ['name' => 'Merokok di lingkungan sekolah', 'category' => 'sedang', 'points' => 15],
            ['name' => 'Berkelahi di sekolah', 'category' => 'berat', 'points' => 25],
            ['name' => 'Membully teman', 'category' => 'berat', 'points' => 20],
            ['name' => 'Merusak fasilitas sekolah', 'category' => 'berat', 'points' => 20],
            ['name' => 'Mencuri', 'category' => 'berat', 'points' => 30],
        ];
        foreach ($violationTypes as $vt) {
            ViolationType::create($vt);
        }

        // Achievement Types
        $achievementTypes = [
            ['name' => 'Juara kelas', 'category' => 'akademik', 'points' => 10],
            ['name' => 'Juara lomba tingkat kabupaten', 'category' => 'akademik', 'points' => 15],
            ['name' => 'Juara lomba tingkat provinsi', 'category' => 'akademik', 'points' => 20],
            ['name' => 'Juara lomba tingkat nasional', 'category' => 'akademik', 'points' => 30],
            ['name' => 'Aktif organisasi OSIS', 'category' => 'non_akademik', 'points' => 10],
            ['name' => 'Menjadi ketua kelas teladan', 'category' => 'karakter', 'points' => 10],
            ['name' => 'Membantu korban bencana', 'category' => 'karakter', 'points' => 15],
        ];
        foreach ($achievementTypes as $at) {
            AchievementType::create($at);
        }

        // === CREATE USERS ===

        // Admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@smk.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        // Kepala Sekolah
        $kepsek = User::create([
            'name' => 'Drs. Budi Santoso, M.Pd',
            'email' => 'kepsek@smk.sch.id',
            'password' => Hash::make('password'),
            'role' => 'kepsek',
            'phone' => '081234567891',
            'is_active' => true,
        ]);

        // Guru BK
        $guruBK1 = User::create([
            'name' => 'Siti Aminah, S.Pd',
            'email' => 'guru.bk1@smk.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru_bk',
            'phone' => '081234567892',
            'is_active' => true,
        ]);
        Teacher::create(['user_id' => $guruBK1->id, 'nip' => '198001012010012001', 'specialization' => 'Konseling Pribadi & Sosial']);

        $guruBK2 = User::create([
            'name' => 'Ahmad Fauzi, S.Pd',
            'email' => 'guru.bk2@smk.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru_bk',
            'phone' => '081234567893',
            'is_active' => true,
        ]);
        Teacher::create(['user_id' => $guruBK2->id, 'nip' => '198505152012011002', 'specialization' => 'Konseling Belajar & Karier']);

        // Wali Kelas
        $waliKelas1 = User::create([
            'name' => 'Dewi Lestari, S.Pd',
            'email' => 'wali.kelas1@smk.sch.id',
            'password' => Hash::make('password'),
            'role' => 'wali_kelas',
            'phone' => '081234567894',
            'is_active' => true,
        ]);
        Teacher::create(['user_id' => $waliKelas1->id, 'nip' => '199003212015012003']);

        $waliKelas2 = User::create([
            'name' => 'Rudi Hartono, S.T',
            'email' => 'wali.kelas2@smk.sch.id',
            'password' => Hash::make('password'),
            'role' => 'wali_kelas',
            'phone' => '081234567895',
            'is_active' => true,
        ]);
        Teacher::create(['user_id' => $waliKelas2->id, 'nip' => '199112012016011004']);

        // Classes
        $class1 = SchoolClass::create([
            'name' => 'RPL 1', 'level' => 'X', 'major' => 'Rekayasa Perangkat Lunak',
            'academic_year_id' => $ay->id, 'wali_kelas_id' => $waliKelas1->id,
        ]);
        $class2 = SchoolClass::create([
            'name' => 'TKJ 1', 'level' => 'X', 'major' => 'Teknik Komputer & Jaringan',
            'academic_year_id' => $ay->id, 'wali_kelas_id' => $waliKelas2->id,
        ]);
        $class3 = SchoolClass::create([
            'name' => 'RPL 1', 'level' => 'XI', 'major' => 'Rekayasa Perangkat Lunak',
            'academic_year_id' => $ay->id,
        ]);
        $class4 = SchoolClass::create([
            'name' => 'TKJ 1', 'level' => 'XI', 'major' => 'Teknik Komputer & Jaringan',
            'academic_year_id' => $ay->id,
        ]);

        // Students (10 sample)
        $studentNames = [
            ['name' => 'Andi Pratama', 'gender' => 'L', 'parent' => 'Bpk. Pratama', 'parent_phone' => '081300000001'],
            ['name' => 'Budi Setiawan', 'gender' => 'L', 'parent' => 'Bpk. Setiawan', 'parent_phone' => '081300000002'],
            ['name' => 'Citra Dewi', 'gender' => 'P', 'parent' => 'Ibu Dewi', 'parent_phone' => '081300000003'],
            ['name' => 'Diana Putri', 'gender' => 'P', 'parent' => 'Ibu Sari', 'parent_phone' => '081300000004'],
            ['name' => 'Eko Prasetyo', 'gender' => 'L', 'parent' => 'Bpk. Prasetyo', 'parent_phone' => '081300000005'],
            ['name' => 'Fitri Handayani', 'gender' => 'P', 'parent' => 'Ibu Handayani', 'parent_phone' => '081300000006'],
            ['name' => 'Galih Ramadhan', 'gender' => 'L', 'parent' => 'Bpk. Ramadhan', 'parent_phone' => '081300000007'],
            ['name' => 'Hana Safira', 'gender' => 'P', 'parent' => 'Ibu Safira', 'parent_phone' => '081300000008'],
            ['name' => 'Irfan Maulana', 'gender' => 'L', 'parent' => 'Bpk. Maulana', 'parent_phone' => '081300000009'],
            ['name' => 'Julia Anggraini', 'gender' => 'P', 'parent' => 'Ibu Anggraini', 'parent_phone' => '081300000010'],
        ];

        $classes = [$class1, $class2, $class3, $class4];
        $students = [];

        foreach ($studentNames as $i => $sn) {
            $user = User::create([
                'name' => $sn['name'],
                'email' => strtolower(str_replace(' ', '.', $sn['name'])) . '@siswa.smk.sch.id',
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'is_active' => true,
            ]);

            $students[] = Student::create([
                'user_id' => $user->id,
                'class_id' => $classes[$i % count($classes)]->id,
                'nis' => '2025' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'nisn' => '00' . str_pad($i + 1, 8, '0', STR_PAD_LEFT),
                'gender' => $sn['gender'],
                'birth_date' => now()->subYears(16)->subDays($i * 30),
                'birth_place' => 'Kota Nusantara',
                'address' => 'Jl. Siswa No. ' . ($i + 1),
                'parent_name' => $sn['parent'],
                'parent_phone' => $sn['parent_phone'],
                'initial_points' => 100,
                'current_points' => 100,
            ]);
        }

        // Demo: Violations for first 3 students
        $violationTypeIds = ViolationType::pluck('id')->toArray();
        foreach ([0, 1, 2] as $si) {
            $vtId = $violationTypeIds[array_rand($violationTypeIds)];
            $vt = ViolationType::find($vtId);
            $violation = Violation::create([
                'student_id' => $students[$si]->id,
                'violation_type_id' => $vtId,
                'recorded_by' => $guruBK1->id,
                'date' => now()->subDays(rand(1, 30)),
                'description' => 'Pelanggaran tercatat oleh Guru BK.',
                'points_deducted' => $vt->points,
            ]);
            $students[$si]->current_points -= $vt->points;
            $students[$si]->save();
            PointHistory::create([
                'student_id' => $students[$si]->id,
                'type' => 'violation',
                'reference_id' => $violation->id,
                'points' => -$vt->points,
                'balance_after' => $students[$si]->current_points,
                'description' => 'Pelanggaran: ' . $vt->name,
                'date' => $violation->date,
            ]);
        }

        // Demo: Achievements for students 3-5
        $achievementTypeIds = AchievementType::pluck('id')->toArray();
        foreach ([3, 4, 5] as $si) {
            $atId = $achievementTypeIds[array_rand($achievementTypeIds)];
            $at = AchievementType::find($atId);
            $achievement = Achievement::create([
                'student_id' => $students[$si]->id,
                'achievement_type_id' => $atId,
                'recorded_by' => $guruBK1->id,
                'date' => now()->subDays(rand(1, 30)),
                'description' => 'Prestasi tercatat.',
                'points_added' => $at->points,
            ]);
            $students[$si]->current_points += $at->points;
            $students[$si]->save();
            PointHistory::create([
                'student_id' => $students[$si]->id,
                'type' => 'achievement',
                'reference_id' => $achievement->id,
                'points' => $at->points,
                'balance_after' => $students[$si]->current_points,
                'description' => 'Prestasi: ' . $at->name,
                'date' => $achievement->date,
            ]);
        }

        // Demo: Counseling records
        $catIds = CounselingCategory::pluck('id')->toArray();
        foreach ([0, 1, 4, 6] as $si) {
            Counseling::create([
                'student_id' => $students[$si]->id,
                'counselor_id' => $guruBK1->id,
                'category_id' => $catIds[array_rand($catIds)],
                'date' => now()->subDays(rand(1, 15)),
                'problem' => 'Siswa mengalami kesulitan dalam hal tertentu dan membutuhkan bimbingan.',
                'solution' => 'Dilakukan pendekatan dan pemberian motivasi.',
                'follow_up' => 'Monitoring dalam 2 minggu ke depan.',
                'status' => ['pending', 'ongoing', 'completed'][array_rand(['pending', 'ongoing', 'completed'])],
            ]);
        }
    }
}
