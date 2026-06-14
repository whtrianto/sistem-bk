<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\PointHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PointController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with('user', 'schoolClass');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nis', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($q2) => $q2->where('name', 'like', "%{$search}%"));
            });
        }
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        $sort = $request->get('sort', 'current_points');
        $order = $request->get('order', 'asc');
        $query->orderBy($sort, $order);

        $students = $query->paginate(15)->appends($request->query());
        return view('points.index', compact('students'));
    }

    public function show(Student $student)
    {
        $student->load('user', 'schoolClass');
        $histories = PointHistory::where('student_id', $student->id)->latest()->paginate(20);
        return view('points.show', compact('student', 'histories'));
    }

    public function ranking()
    {
        $students = Student::with('user', 'schoolClass')
            ->orderByDesc('current_points')
            ->take(50)
            ->get();
        return view('points.ranking', compact('students'));
    }
}
