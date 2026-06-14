<?php

namespace App\Http\Controllers;

use App\Models\Counseling;
use App\Models\CounselingCategory;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CounselingController extends Controller
{
    public function index(Request $request)
    {
        $query = Counseling::with('student.user', 'counselor', 'category');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('search')) {
            $query->whereHas('student.user', fn($q) => $q->where('name', 'like', "%{$request->search}%"));
        }

        // Wali kelas only sees their class students
        if (Auth::user()->isWaliKelas()) {
            $studentIds = Student::whereIn('class_id',
                Auth::user()->waliKelasClasses->pluck('id')
            )->pluck('id');
            $query->whereIn('student_id', $studentIds);
        }

        $counselings = $query->latest()->paginate(15)->appends($request->query());
        $categories = CounselingCategory::all();
        return view('counselings.index', compact('counselings', 'categories'));
    }

    public function create()
    {
        $students = Student::with('user', 'schoolClass')->get();
        $categories = CounselingCategory::all();
        $counselors = User::where('role', 'guru_bk')->get();
        return view('counselings.create', compact('students', 'categories', 'counselors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'category_id' => 'required|exists:counseling_categories,id',
            'date' => 'required|date',
            'problem' => 'required|string',
        ]);

        Counseling::create([
            'student_id' => $request->student_id,
            'counselor_id' => Auth::id(),
            'category_id' => $request->category_id,
            'date' => $request->date,
            'problem' => $request->problem,
            'solution' => $request->solution,
            'follow_up' => $request->follow_up,
            'status' => $request->status ?? 'pending',
            'is_confidential' => $request->boolean('is_confidential'),
        ]);

        return redirect()->route('counselings.index')->with('success', 'Data konseling berhasil ditambahkan.');
    }

    public function show(Counseling $counseling)
    {
        $counseling->load('student.user', 'student.schoolClass', 'counselor', 'category');
        return view('counselings.show', compact('counseling'));
    }

    public function edit(Counseling $counseling)
    {
        $counseling->load('student.user');
        $students = Student::with('user', 'schoolClass')->get();
        $categories = CounselingCategory::all();
        return view('counselings.edit', compact('counseling', 'students', 'categories'));
    }

    public function update(Request $request, Counseling $counseling)
    {
        $request->validate([
            'status' => 'required|in:pending,ongoing,completed',
        ]);

        $counseling->update([
            'solution' => $request->solution,
            'follow_up' => $request->follow_up,
            'status' => $request->status,
        ]);

        return redirect()->route('counselings.show', $counseling)->with('success', 'Data konseling berhasil diperbarui.');
    }

    public function destroy(Counseling $counseling)
    {
        $counseling->delete();
        return redirect()->route('counselings.index')->with('success', 'Data konseling berhasil dihapus.');
    }
}
