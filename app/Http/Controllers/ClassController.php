<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\AcademicYear;
use App\Models\User;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::with('academicYear', 'waliKelas')->latest()->paginate(15);
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        $academicYears = AcademicYear::all();
        $teachers = User::whereIn('role', ['guru_bk', 'wali_kelas'])->where('is_active', true)->get();
        return view('classes.create', compact('academicYears', 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'level' => 'required|in:X,XI,XII',
            'major' => 'required|string|max:255',
            'academic_year_id' => 'required|exists:academic_years,id',
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);

        SchoolClass::create($request->all());

        return redirect()->route('classes.index')->with('success', 'Kelas berhasil dibuat.');
    }

    public function edit(SchoolClass $class)
    {
        $academicYears = AcademicYear::all();
        $teachers = User::whereIn('role', ['guru_bk', 'wali_kelas'])->where('is_active', true)->get();
        return view('classes.edit', compact('class', 'academicYears', 'teachers'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'level' => 'required|in:X,XI,XII',
            'major' => 'required|string|max:255',
            'academic_year_id' => 'required|exists:academic_years,id',
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);

        $class->update($request->all());

        return redirect()->route('classes.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(SchoolClass $class)
    {
        $class->delete();
        return redirect()->route('classes.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
