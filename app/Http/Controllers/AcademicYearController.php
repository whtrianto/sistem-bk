<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcademicYearController extends Controller
{
    public function index()
    {
        $years = AcademicYear::latest()->paginate(15);
        return view('academic_years.index', compact('years'));
    }

    public function create()
    {
        return view('academic_years.create');
    }

    public function store(Request $request)
    {
        $request->merge(['semester' => $request->semester ?? 'ganjil']);
        $request->validate([
            'year' => 'required|string|max:10',
            'semester' => 'required|in:ganjil,genap',
        ]);

        DB::transaction(function() use ($request) {
            $isActive = $request->boolean('is_active', false);
            if ($isActive) {
                AcademicYear::query()->update(['is_active' => false]);
            }

            AcademicYear::create([
                'year' => $request->year,
                'semester' => $request->semester,
                'is_active' => $isActive,
            ]);
        });

        return redirect()->route('academic-years.index')->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function edit(AcademicYear $academicYear)
    {
        return view('academic_years.edit', compact('academicYear'));
    }

    public function update(Request $request, AcademicYear $academicYear)
    {
        $request->merge(['semester' => $request->semester ?? $academicYear->semester ?? 'ganjil']);
        $request->validate([
            'year' => 'required|string|max:10',
            'semester' => 'required|in:ganjil,genap',
        ]);

        DB::transaction(function() use ($request, $academicYear) {
            $isActive = $request->boolean('is_active', false);
            if ($isActive) {
                AcademicYear::query()->where('id', '!=', $academicYear->id)->update(['is_active' => false]);
            }

            $academicYear->update([
                'year' => $request->year,
                'semester' => $request->semester,
                'is_active' => $isActive,
            ]);
        });

        return redirect()->route('academic-years.index')->with('success', 'Tahun ajaran berhasil diperbarui.');
    }

    public function destroy(AcademicYear $academicYear)
    {
        $academicYear->delete();
        return redirect()->route('academic-years.index')->with('success', 'Tahun ajaran berhasil dihapus.');
    }

    public function toggleActive(AcademicYear $academicYear)
    {
        DB::transaction(function() use ($academicYear) {
            AcademicYear::query()->update(['is_active' => false]);
            $academicYear->update(['is_active' => true]);
        });

        return back()->with('success', 'Tahun ajaran aktif berhasil diubah.');
    }
}
