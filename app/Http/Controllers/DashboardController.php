<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Counseling;
use App\Models\CounselingSchedule;
use App\Models\Violation;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\CounselingCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return match($user->role) {
            'admin' => $this->adminDashboard(),
            'guru_bk' => $this->guruBKDashboard(),
            'wali_kelas' => $this->waliKelasDashboard(),
            'siswa' => $this->siswaDashboard(),
            'kepsek' => $this->kepsekDashboard(),
            default => abort(403),
        };
    }

    private function adminDashboard()
    {
        $data = [
            'totalUsers' => User::count(),
            'totalStudents' => Student::count(),
            'totalClasses' => SchoolClass::count(),
            'totalTeachers' => User::whereIn('role', ['guru_bk', 'wali_kelas'])->count(),
            'activeUsers' => User::where('is_active', true)->count(),
            'recentUsers' => User::latest()->take(5)->get(),
        ];
        return view('dashboard.admin', $data);
    }

    private function guruBKDashboard()
    {
        $data = [
            'totalCounselings' => Counseling::count(),
            'pendingCounselings' => Counseling::where('status', 'pending')->count(),
            'ongoingCounselings' => Counseling::where('status', 'ongoing')->count(),
            'completedCounselings' => Counseling::where('status', 'completed')->count(),
            'todaySchedules' => CounselingSchedule::whereDate('date', today())
                ->where('status', 'approved')->with('student.user')->get(),
            'pendingSchedules' => CounselingSchedule::where('status', 'pending')->count(),
            'recentViolations' => Violation::with('student.user', 'violationType')
                ->latest()->take(5)->get(),
            'totalViolations' => Violation::count(),
            // Monthly counseling chart data
            'monthlyCounselings' => array_values(array_replace(array_fill(1, 12, 0), Counseling::select(
                    DB::raw('MONTH(date) as month'),
                    DB::raw('COUNT(*) as total')
                )->whereYear('date', now()->year)
                ->groupBy(DB::raw('MONTH(date)'))
                ->pluck('total', 'month')->toArray())),
            // Category chart data
            'categoryCounts' => Counseling::select('category_id', DB::raw('COUNT(*) as total'))
                ->groupBy('category_id')
                ->with('category')
                ->get(),
        ];
        return view('dashboard.guru-bk', $data);
    }

    private function waliKelasDashboard()
    {
        $user = Auth::user();
        $myClasses = SchoolClass::where('wali_kelas_id', $user->id)->with('students.user')->get();
        $studentIds = $myClasses->pluck('students')->flatten()->pluck('id')->toArray();

        $data = [
            'myClasses' => $myClasses,
            'totalStudents' => count($studentIds),
            'recentViolations' => Violation::whereIn('student_id', $studentIds)
                ->with('student.user', 'violationType')->latest()->take(5)->get(),
            'totalViolations' => Violation::whereIn('student_id', $studentIds)->count(),
            'avgPoints' => Student::whereIn('id', $studentIds)->avg('current_points') ?? 0,
        ];
        return view('dashboard.wali-kelas', $data);
    }

    private function siswaDashboard()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        $data = [
            'student' => $student,
            'currentPoints' => $student ? $student->current_points : 0,
            'totalViolations' => $student ? $student->violations()->count() : 0,
            'recentHistory' => $student ? $student->pointHistories()->latest()->take(10)->get() : collect(),
            'upcomingSchedules' => $student ? CounselingSchedule::where('student_id', $student->id)
                ->where('date', '>=', today())
                ->where('status', 'approved')
                ->orderBy('date')->take(3)->get() : collect(),
            'mySchedules' => $student ? CounselingSchedule::where('student_id', $student->id)
                ->latest()->take(5)->get() : collect(),
        ];
        return view('dashboard.siswa', $data);
    }

    private function kepsekDashboard()
    {
        $data = [
            'totalStudents' => Student::count(),
            'totalCounselings' => Counseling::count(),
            'totalViolations' => Violation::count(),
            // Monthly violation chart
            'monthlyViolations' => array_values(array_replace(array_fill(1, 12, 0), Violation::select(
                    DB::raw('MONTH(date) as month'),
                    DB::raw('COUNT(*) as total')
                )->whereYear('date', now()->year)
                ->groupBy(DB::raw('MONTH(date)'))
                ->pluck('total', 'month')->toArray())),
            // Monthly counseling chart
            'monthlyCounselings' => array_values(array_replace(array_fill(1, 12, 0), Counseling::select(
                    DB::raw('MONTH(date) as month'),
                    DB::raw('COUNT(*) as total')
                )->whereYear('date', now()->year)
                ->groupBy(DB::raw('MONTH(date)'))
                ->pluck('total', 'month')->toArray())),
            // Category chart
            'categoryCounts' => Counseling::select('category_id', DB::raw('COUNT(*) as total'))
                ->groupBy('category_id')
                ->with('category')
                ->get(),
            // Violation by class
            'violationByClass' => DB::table('violations')
                ->join('students', 'violations.student_id', '=', 'students.id')
                ->join('school_classes', 'students.class_id', '=', 'school_classes.id')
                ->select('school_classes.name as class_name', 'school_classes.level', DB::raw('COUNT(*) as total'))
                ->groupBy('school_classes.name', 'school_classes.level')
                ->get(),
        ];
        return view('dashboard.kepsek', $data);
    }
}
