<?php

namespace App\Http\Controllers;

use App\Models\AchievementType;
use Illuminate\Http\Request;

class AchievementTypeController extends Controller
{
    public function index()
    {
        $types = AchievementType::latest()->paginate(15);
        return view('achievement_types.index', compact('types'));
    }

    public function create()
    {
        return view('achievement_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:akademik,non_akademik,karakter',
            'points' => 'required|integer|min:1',
        ]);

        AchievementType::create($request->all());

        return redirect()->route('achievement-types.index')->with('success', 'Jenis prestasi berhasil ditambahkan.');
    }

    public function edit(AchievementType $achievementType)
    {
        return view('achievement_types.edit', compact('achievementType'));
    }

    public function update(Request $request, AchievementType $achievementType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:akademik,non_akademik,karakter',
            'points' => 'required|integer|min:1',
        ]);

        $achievementType->update($request->all());

        return redirect()->route('achievement-types.index')->with('success', 'Jenis prestasi berhasil diperbarui.');
    }

    public function destroy(AchievementType $achievementType)
    {
        $achievementType->delete();
        return redirect()->route('achievement-types.index')->with('success', 'Jenis prestasi berhasil dihapus.');
    }
}
