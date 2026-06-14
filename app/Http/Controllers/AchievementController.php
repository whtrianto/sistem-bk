<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\AchievementType;
use App\Models\Student;
use App\Models\PointHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $query = Achievement::with('student.user', 'student.schoolClass', 'achievementType', 'recorder');

        if ($request->filled('search')) {
            $query->whereHas('student.user', fn($q) => $q->where('name', 'like', "%{$request->search}%"));
        }

        $achievements = $query->latest()->paginate(15)->appends($request->query());
        return view('achievements.index', compact('achievements'));
    }

    public function create()
    {
        $students = Student::with('user', 'schoolClass')->get();
        $achievementTypes = AchievementType::all();
        return view('achievements.create', compact('students', 'achievementTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'achievement_type_id' => 'required|exists:achievement_types,id',
            'date' => 'required|date',
        ]);

        $achievementType = AchievementType::findOrFail($request->achievement_type_id);
        $student = Student::findOrFail($request->student_id);

        $achievement = Achievement::create([
            'student_id' => $request->student_id,
            'achievement_type_id' => $request->achievement_type_id,
            'recorded_by' => Auth::id(),
            'date' => $request->date,
            'description' => $request->description,
            'points_added' => $achievementType->points,
        ]);

        $student->current_points += $achievementType->points;
        $student->save();

        PointHistory::create([
            'student_id' => $student->id,
            'type' => 'achievement',
            'reference_id' => $achievement->id,
            'points' => $achievementType->points,
            'balance_after' => $student->current_points,
            'description' => 'Prestasi: ' . $achievementType->name,
            'date' => $request->date,
        ]);

        return redirect()->route('achievements.index')->with('success', 'Prestasi berhasil dicatat. Poin siswa bertambah ' . $achievementType->points . ' poin.');
    }

    public function destroy(Achievement $achievement)
    {
        $student = $achievement->student;
        $student->current_points -= $achievement->points_added;
        $student->save();

        PointHistory::where('type', 'achievement')->where('reference_id', $achievement->id)->delete();
        $achievement->delete();

        return redirect()->route('achievements.index')->with('success', 'Data prestasi berhasil dihapus.');
    }
}
