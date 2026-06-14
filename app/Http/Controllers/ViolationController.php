<?php

namespace App\Http\Controllers;

use App\Models\Violation;
use App\Models\ViolationType;
use App\Models\Student;
use App\Models\PointHistory;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViolationController extends Controller
{
    public function index(Request $request)
    {
        $query = Violation::with('student.user', 'student.schoolClass', 'violationType', 'recorder');

        if ($request->filled('search')) {
            $query->whereHas('student.user', fn($q) => $q->where('name', 'like', "%{$request->search}%"));
        }
        if ($request->filled('category')) {
            $query->whereHas('violationType', fn($q) => $q->where('category', $request->category));
        }

        $violations = $query->latest()->paginate(15)->appends($request->query());
        return view('violations.index', compact('violations'));
    }

    public function create()
    {
        $students = Student::with('user', 'schoolClass')->get();
        $violationTypes = ViolationType::all();
        return view('violations.create', compact('students', 'violationTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'violation_type_id' => 'required|exists:violation_types,id',
            'date' => 'required|date',
        ]);

        $violationType = ViolationType::findOrFail($request->violation_type_id);
        $student = Student::findOrFail($request->student_id);

        $violation = Violation::create([
            'student_id' => $request->student_id,
            'violation_type_id' => $request->violation_type_id,
            'recorded_by' => Auth::id(),
            'date' => $request->date,
            'description' => $request->description,
            'points_deducted' => $violationType->points,
        ]);

        // Update student points
        $student->current_points -= $violationType->points;
        $student->save();

        // Record point history
        PointHistory::create([
            'student_id' => $student->id,
            'type' => 'violation',
            'reference_id' => $violation->id,
            'points' => -$violationType->points,
            'balance_after' => $student->current_points,
            'description' => 'Pelanggaran: ' . $violationType->name,
            'date' => $request->date,
        ]);

        // Send WhatsApp notification
        if ($student->parent_phone && $request->boolean('send_wa')) {
            $student->load('user', 'schoolClass');
            $violation->load('violationType');
            $waService = new WhatsAppService();
            $waService->sendViolationNotification($student, $violation);
        }

        return redirect()->route('violations.index')->with('success', 'Pelanggaran berhasil dicatat. Poin siswa dikurangi ' . $violationType->points . ' poin.');
    }

    public function destroy(Violation $violation)
    {
        $student = $violation->student;
        $student->current_points += $violation->points_deducted;
        $student->save();

        PointHistory::where('type', 'violation')->where('reference_id', $violation->id)->delete();
        $violation->delete();

        return redirect()->route('violations.index')->with('success', 'Data pelanggaran berhasil dihapus.');
    }
}
