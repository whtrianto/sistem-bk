<?php

namespace App\Http\Controllers;

use App\Models\Counseling;
use App\Models\Violation;
use App\Models\Achievement;
use App\Models\Student;
use App\Models\CounselingCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year', now()->year);

        $monthlyViolations = Violation::select(
            DB::raw('MONTH(date) as month'), DB::raw('COUNT(*) as total')
        )->whereYear('date', $year)->groupBy(DB::raw('MONTH(date)'))->pluck('total', 'month')->toArray();
        $monthlyViolations = array_values(array_replace(array_fill(1, 12, 0), $monthlyViolations));

        $monthlyCounselings = Counseling::select(
            DB::raw('MONTH(date) as month'), DB::raw('COUNT(*) as total')
        )->whereYear('date', $year)->groupBy(DB::raw('MONTH(date)'))->pluck('total', 'month')->toArray();
        $monthlyCounselings = array_values(array_replace(array_fill(1, 12, 0), $monthlyCounselings));

        $monthlyAchievements = Achievement::select(
            DB::raw('MONTH(date) as month'), DB::raw('COUNT(*) as total')
        )->whereYear('date', $year)->groupBy(DB::raw('MONTH(date)'))->pluck('total', 'month')->toArray();
        $monthlyAchievements = array_values(array_replace(array_fill(1, 12, 0), $monthlyAchievements));

        $categoryCounts = Counseling::select('category_id', DB::raw('COUNT(*) as total'))
            ->whereYear('date', $year)->groupBy('category_id')->with('category')->get();

        $violationByCategory = Violation::join('violation_types', 'violations.violation_type_id', '=', 'violation_types.id')
            ->select('violation_types.category', DB::raw('COUNT(*) as total'))
            ->whereYear('violations.date', $year)->groupBy('violation_types.category')->pluck('total', 'category')->toArray();

        $totalStats = [
            'violations' => Violation::whereYear('date', $year)->count(),
            'counselings' => Counseling::whereYear('date', $year)->count(),
            'achievements' => Achievement::whereYear('date', $year)->count(),
            'students' => Student::count(),
        ];

        return view('reports.index', compact(
            'year', 'monthlyViolations', 'monthlyCounselings', 'monthlyAchievements',
            'categoryCounts', 'violationByCategory', 'totalStats'
        ));
    }
}
