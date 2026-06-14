@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="mb-4">
        <a href="{{ route('admin.users.index') }}" class="btn btn-link text-decoration-none p-0"><i class="bi bi-arrow-left"></i> Kembali ke Daftar User</a>
        <h3 class="fw-bold mt-2 text-dark">Edit User: {{ $user->name }}</h3>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger border-0 mb-4" style="border-radius: 12px;">
            <ul class="m-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-6">
            <div class="card border-0 glass-card p-4">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Pengguna <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $user->name) }}">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control" required value="{{ old('email', $user->email) }}">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Kata Sandi (Biarkan kosong jika tetap)</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password baru jika ingin diubah">
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label fw-semibold">No. WhatsApp</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label fw-semibold">Peran (Role) <span class="text-danger">*</span></label>
                        <select name="role" id="role" class="form-select" required onchange="toggleTeacherFields()">
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="guru_bk" {{ old('role', $user->role) == 'guru_bk' ? 'selected' : '' }}>Guru BK</option>
                            <option value="wali_kelas" {{ old('role', $user->role) == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                            <option value="siswa" {{ old('role', $user->role) == 'siswa' ? 'selected' : '' }}>Siswa</option>
                            <option value="kepsek" {{ old('role', $user->role) == 'kepsek' ? 'selected' : '' }}>Kepala Sekolah</option>
                        </select>
                    </div>

                    <!-- Teacher Fields (Hidden by default, shown if role is BK/Wali Kelas) -->
                    <div id="teacher-fields" style="display: none;" class="bg-light p-3 rounded-3 border mb-3">
                        <h6 class="fw-bold text-secondary mb-3"><i class="bi bi-briefcase me-1"></i> Data Kepegawaian Guru</h6>
                        <div class="mb-3">
                            <label for="nip" class="form-label fw-semibold">NIP</label>
                            <input type="text" name="nip" id="nip" class="form-control" value="{{ old('nip', $user->teacher->nip ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="specialization" class="form-label fw-semibold">Spesialisasi / Keahlian</label>
                            <input type="text" name="specialization" id="specialization" class="form-control" value="{{ old('specialization', $user->teacher->specialization ?? '') }}">
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary-custom px-4"><i class="bi bi-save me-2"></i> Perbarui User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleTeacherFields() {
        const roleSelect = document.getElementById('role');
        const teacherFields = document.getElementById('teacher-fields');
        if (roleSelect.value === 'guru_bk' || roleSelect.value === 'wali_kelas') {
            teacherFields.style.display = 'block';
        } else {
            teacherFields.style.display = 'none';
        }
    }
    document.addEventListener('DOMContentLoaded', toggleTeacherFields);
</script>
@endsection
