@extends('layouts.app')

@section('title', 'Tambah Guru')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="mb-4">
        <a href="{{ route('teachers.index') }}" class="btn btn-link text-decoration-none p-0"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Guru</a>
        <h3 class="fw-bold mt-2 text-dark">Tambah Guru Baru</h3>
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
        <div class="col-lg-8">
            <div class="card border-0 glass-card p-4">
                <form action="{{ route('teachers.store') }}" method="POST">
                    @csrf
                    
                    <h5 class="fw-bold mb-3 text-secondary border-bottom pb-2"><i class="bi bi-person-badge-fill text-primary me-2"></i>Informasi Akun</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nama beserta gelar" required value="{{ old('name') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="guru@sekolah.sch.id" required value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label fw-semibold">Kata Sandi (Default: password)</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Biarkan kosong jika ingin default">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label fw-semibold">No. Telepon / WhatsApp</label>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="08xxxxxxxxxx" value="{{ old('phone') }}">
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3 mt-4 text-secondary border-bottom pb-2"><i class="bi bi-briefcase-fill text-success me-2"></i>Informasi Guru</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label fw-semibold">Peran Guru <span class="text-danger">*</span></label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="">Pilih Peran</option>
                                <option value="guru_bk" {{ old('role') == 'guru_bk' ? 'selected' : '' }}>Guru Bimbingan Konseling (BK)</option>
                                <option value="wali_kelas" {{ old('role') == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nip" class="form-label fw-semibold">NIP</label>
                            <input type="text" name="nip" id="nip" class="form-control" placeholder="Nomor Induk Pegawai" value="{{ old('nip') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="specialization" class="form-label fw-semibold">Spesialisasi / Keterangan Keahlian</label>
                        <input type="text" name="specialization" id="specialization" class="form-control" placeholder="Contoh: Konseling Pribadi & Sosial, Guru Matematika, dll." value="{{ old('specialization') }}">
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary-custom px-4"><i class="bi bi-save me-2"></i> Simpan Guru</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
