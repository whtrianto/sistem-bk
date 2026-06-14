<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['guru_bk', 'wali_kelas'])->with('teacher');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('teacher', fn($q2) => $q2->where('nip', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $teachers = $query->latest()->paginate(15)->appends($request->query());
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:guru_bk,wali_kelas',
            'nip' => 'nullable|unique:teachers,nip',
        ]);

        DB::transaction(function() use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password ?? 'password'),
                'role' => $request->role,
                'phone' => $request->phone,
                'is_active' => true,
            ]);

            Teacher::create([
                'user_id' => $user->id,
                'nip' => $request->nip,
                'specialization' => $request->specialization,
            ]);
        });

        return redirect()->route('teachers.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit(User $teacher)
    {
        $teacher->load('teacher');
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, User $teacher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $teacher->id,
            'role' => 'required|in:guru_bk,wali_kelas',
            'nip' => 'nullable|unique:teachers,nip,' . ($teacher->teacher->id ?? 0),
        ]);

        DB::transaction(function() use ($request, $teacher) {
            $teacher->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'phone' => $request->phone,
            ]);

            if ($request->filled('password')) {
                $teacher->update(['password' => Hash::make($request->password)]);
            }

            if ($teacher->teacher) {
                $teacher->teacher->update([
                    'nip' => $request->nip,
                    'specialization' => $request->specialization,
                ]);
            } else {
                Teacher::create([
                    'user_id' => $teacher->id,
                    'nip' => $request->nip,
                    'specialization' => $request->specialization,
                ]);
            }
        });

        return redirect()->route('teachers.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(User $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
