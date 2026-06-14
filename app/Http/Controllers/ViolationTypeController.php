<?php

namespace App\Http\Controllers;

use App\Models\ViolationType;
use Illuminate\Http\Request;

class ViolationTypeController extends Controller
{
    public function index()
    {
        $types = ViolationType::latest()->paginate(15);
        return view('violation_types.index', compact('types'));
    }

    public function create()
    {
        return view('violation_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:ringan,sedang,berat',
            'points' => 'required|integer|min:1',
        ]);

        ViolationType::create($request->all());

        return redirect()->route('violation-types.index')->with('success', 'Jenis pelanggaran berhasil ditambahkan.');
    }

    public function edit(ViolationType $violationType)
    {
        return view('violation_types.edit', compact('violationType'));
    }

    public function update(Request $request, ViolationType $violationType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:ringan,sedang,berat',
            'points' => 'required|integer|min:1',
        ]);

        $violationType->update($request->all());

        return redirect()->route('violation-types.index')->with('success', 'Jenis pelanggaran berhasil diperbarui.');
    }

    public function destroy(ViolationType $violationType)
    {
        $violationType->delete();
        return redirect()->route('violation-types.index')->with('success', 'Jenis pelanggaran berhasil dihapus.');
    }
}
