<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ViolationTypeController;
use App\Http\Controllers\AchievementTypeController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\CounselingController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Only
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::post('users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
        Route::get('settings/wa-logs', [SettingController::class, 'waLogs'])->name('settings.wa-logs');
        Route::post('settings/wa-test', [SettingController::class, 'waTest'])->name('settings.wa-test');
    });

    // Admin & Guru BK
    Route::middleware('role:admin,guru_bk')->group(function () {
        Route::resource('students', StudentController::class)->except(['show']);
        Route::resource('classes', ClassController::class);
        Route::resource('teachers', TeacherController::class);
        Route::resource('violation-types', ViolationTypeController::class);
        Route::resource('academic-years', AcademicYearController::class);
        Route::post('academic-years/{academic_year}/toggle-active', [AcademicYearController::class, 'toggleActive'])->name('academic-years.toggle-active');
    });
    
    // Access to Student profile details (Admin, Guru BK, Wali Kelas, Kepsek)
    Route::middleware('role:admin,guru_bk,wali_kelas,kepsek')->group(function () {
        Route::get('students/{student}', [StudentController::class, 'show'])->name('students.show');
    });

    // Access to Violations (Admin, Guru BK, Wali Kelas)
    Route::middleware('role:admin,guru_bk,wali_kelas')->group(function () {
        Route::resource('violations', ViolationController::class)->only(['index', 'create', 'store', 'destroy']);
    });

    // Access to Counseling (Admin, Guru BK, Wali Kelas)
    Route::middleware('role:admin,guru_bk,wali_kelas')->group(function () {
        Route::resource('counselings', CounselingController::class);
    });

    // Schedule Booking (Siswa can request; Guru BK / Admin can approve, reject, complete)
    Route::middleware('role:admin,guru_bk,siswa')->group(function () {
        Route::resource('schedules', ScheduleController::class)->only(['index', 'create', 'store', 'destroy']);
    });

    Route::middleware('role:admin,guru_bk')->group(function () {
        Route::post('schedules/{schedule}/approve', [ScheduleController::class, 'approve'])->name('schedules.approve');
        Route::post('schedules/{schedule}/reject', [ScheduleController::class, 'reject'])->name('schedules.reject');
        Route::post('schedules/{schedule}/complete', [ScheduleController::class, 'complete'])->name('schedules.complete');
    });

    // Point history viewing (Admin, Guru BK, Wali Kelas, Siswa, Kepsek)
    Route::middleware('role:admin,guru_bk,wali_kelas,siswa,kepsek')->group(function () {
        Route::get('points', [PointController::class, 'index'])->name('points.index');
        Route::get('points/ranking', [PointController::class, 'ranking'])->name('points.ranking');
        Route::get('points/{student}', [PointController::class, 'show'])->name('points.show');
    });

    // Parent Letters (Admin, Guru BK)
    Route::middleware('role:admin,guru_bk')->group(function () {
        Route::resource('letters', LetterController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::get('letters/{letter}/pdf', [LetterController::class, 'pdf'])->name('letters.pdf');
    });

    // Reports (Admin, Guru BK, Kepsek)
    Route::middleware('role:admin,guru_bk,kepsek')->group(function () {
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    });
});
