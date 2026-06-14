<?php

namespace App\Http\Controllers;

use App\Models\CounselingSchedule;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = CounselingSchedule::with('student.user', 'counselor');

        if ($user->isSiswa()) {
            $student = Student::where('user_id', $user->id)->first();
            if ($student) {
                $query->where('student_id', $student->id);
            }
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $schedules = $query->latest()->paginate(15)->appends($request->query());
        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        $user = Auth::user();
        $counselors = User::where('role', 'guru_bk')->where('is_active', true)->get();

        if ($user->isSiswa()) {
            $student = Student::where('user_id', $user->id)->first();
            return view('schedules.create', compact('counselors', 'student'));
        }

        $students = Student::with('user', 'schoolClass')->get();
        return view('schedules.create', compact('counselors', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'counselor_id' => 'required|exists:users,id',
            'date' => 'required|date|after_or_equal:today',
            'time_start' => 'required',
            'time_end' => 'required|after:time_start',
        ]);

        $user = Auth::user();
        $studentId = $request->student_id;

        if ($user->isSiswa()) {
            $student = Student::where('user_id', $user->id)->first();
            $studentId = $student->id;
        }

        CounselingSchedule::create([
            'student_id' => $studentId,
            'counselor_id' => $request->counselor_id,
            'date' => $request->date,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
            'notes' => $request->notes,
            'requested_by' => $user->isSiswa() ? 'student' : 'counselor',
            'status' => $user->isGuruBK() ? 'approved' : 'pending',
        ]);

        return redirect()->route('schedules.index')->with('success', 'Jadwal konseling berhasil diajukan.');
    }

    public function approve(CounselingSchedule $schedule)
    {
        $schedule->update(['status' => 'approved']);
        return back()->with('success', 'Jadwal konseling disetujui.');
    }

    public function reject(Request $request, CounselingSchedule $schedule)
    {
        $schedule->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);
        return back()->with('success', 'Jadwal konseling ditolak.');
    }

    public function complete(CounselingSchedule $schedule)
    {
        $schedule->update(['status' => 'completed']);
        return back()->with('success', 'Jadwal konseling selesai.');
    }

    public function destroy(CounselingSchedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
