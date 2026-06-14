<?php

namespace App\Http\Controllers;

use App\Models\ParentLetter;
use App\Models\Student;
use App\Models\SchoolSetting;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LetterController extends Controller
{
    public function index()
    {
        $letters = ParentLetter::with('student.user', 'student.schoolClass', 'generator')
            ->latest()->paginate(15);
        return view('letters.index', compact('letters'));
    }

    public function create()
    {
        $students = Student::with('user', 'schoolClass')->get();
        return view('letters.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'reason' => 'required|string',
            'meeting_date' => 'required|date|after_or_equal:today',
            'meeting_time' => 'required',
        ]);

        $lastLetter = ParentLetter::latest()->first();
        $nextNumber = $lastLetter ? intval(substr($lastLetter->letter_number, -4)) + 1 : 1;
        $letterNumber = 'SP/' . now()->format('Y/m') . '/' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $letter = ParentLetter::create([
            'student_id' => $request->student_id,
            'generated_by' => Auth::id(),
            'letter_number' => $letterNumber,
            'reason' => $request->reason,
            'meeting_date' => $request->meeting_date,
            'meeting_time' => $request->meeting_time,
            'status' => 'generated',
        ]);

        // Send WhatsApp if requested
        if ($request->boolean('send_wa')) {
            $student = Student::with('user', 'schoolClass')->find($request->student_id);
            if ($student->parent_phone) {
                $waService = new WhatsAppService();
                $waService->sendInvitationNotification($student, $letter);
                $letter->update(['status' => 'sent']);
            }
        }

        return redirect()->route('letters.index')->with('success', 'Surat panggilan berhasil dibuat.');
    }

    public function pdf(ParentLetter $letter)
    {
        $letter->load('student.user', 'student.schoolClass', 'generator');
        $settings = [
            'school_name' => SchoolSetting::getValue('school_name', 'SMK Negeri 1 Nusantara'),
            'school_address' => SchoolSetting::getValue('school_address', 'Jl. Pendidikan No. 1'),
            'school_phone' => SchoolSetting::getValue('school_phone', '(021) 1234567'),
            'principal_name' => SchoolSetting::getValue('principal_name', 'Kepala Sekolah'),
            'principal_nip' => SchoolSetting::getValue('principal_nip', ''),
        ];

        $pdf = Pdf::loadView('letters.pdf', compact('letter', 'settings'));
        $filename = 'surat-panggilan-' . str_replace(['/', '\\'], '-', $letter->letter_number) . '.pdf';
        return $pdf->stream($filename);
    }

    public function destroy(ParentLetter $letter)
    {
        $letter->delete();
        return redirect()->route('letters.index')->with('success', 'Surat berhasil dihapus.');
    }
}
