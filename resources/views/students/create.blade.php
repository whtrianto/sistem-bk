@extends('layouts.app')

@section('title', 'Tambah Siswa')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="mb-4">
        <a href="{{ route('students.index') }}" class="btn btn-link text-decoration-none p-0"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Siswa</a>
        <h3 class="fw-bold mt-2 text-dark">Tambah Siswa Baru</h3>
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

    <form action="{{ route('students.store') }}" method="POST" class="row g-4">
        @csrf
        <!-- Account Info -->
        <div class="col-lg-6">
            <div class="card border-0 glass-card p-4 h-100">
                <h5 class="fw-bold mb-4 text-dark border-bottom pb-2"><i class="bi bi-person-badge-fill me-2 text-primary"></i>Informasi Akun</h5>
                
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama lengkap siswa" required value="{{ old('name') }}">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="siswa@sekolah.sch.id" required value="{{ old('email') }}">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Kata Sandi (Default: password)</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Kata sandi kustom atau kosongkan untuk default">
                </div>

                <div class="mb-3">
                    <label for="gender" class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="gender" id="gender" class="form-select" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Academic Info -->
        <div class="col-lg-6">
            <div class="card border-0 glass-card p-4 h-100">
                <h5 class="fw-bold mb-4 text-dark border-bottom pb-2"><i class="bi bi-mortarboard-fill me-2 text-success"></i>Informasi Akademik</h5>
                
                <div class="mb-3">
                    <label for="nis" class="form-label fw-semibold">Nomor Induk Siswa (NIS) <span class="text-danger">*</span></label>
                    <input type="text" name="nis" id="nis" class="form-control" placeholder="Masukkan NIS" required value="{{ old('nis') }}">
                </div>

                <div class="mb-3">
                    <label for="nisn" class="form-label fw-semibold">NISN</label>
                    <input type="text" name="nisn" id="nisn" class="form-control" placeholder="Masukkan NISN" value="{{ old('nisn') }}">
                </div>

                <div class="mb-3">
                    <label for="class_id" class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                    <select name="class_id" id="class_id" class="form-select" required>
                        <option value="">Pilih Kelas</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="birth_place" class="form-label fw-semibold">Tempat Lahir</label>
                        <input type="text" name="birth_place" id="birth_place" class="form-control" placeholder="Kota lahir" value="{{ old('birth_place') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="birth_date" class="form-label fw-semibold">Tanggal Lahir</label>
                        <input type="date" name="birth_date" id="birth_date" class="form-control" value="{{ old('birth_date') }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal & Parent Info -->
        <div class="col-12">
            <div class="card border-0 glass-card p-4">
                <h5 class="fw-bold mb-4 text-dark border-bottom pb-2"><i class="bi bi-people-fill me-2 text-warning"></i>Informasi Kontak & Orang Tua</h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="parent_name" class="form-label fw-semibold">Nama Wali / Orang Tua</label>
                        <input type="text" name="parent_name" id="parent_name" class="form-control" placeholder="Nama ayah/ibu/wali" value="{{ old('parent_name') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="parent_phone" class="form-label fw-semibold">Nomor WhatsApp Orang Tua (Format: 08xx/62xx)</label>
                        <input type="text" name="parent_phone" id="parent_phone" class="form-control" placeholder="081234567890" value="{{ old('parent_phone') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="address" class="form-label fw-semibold">Alamat Siswa</label>
                        <textarea name="address" id="address" class="form-control" rows="3" placeholder="Alamat lengkap tempat tinggal siswa">{{ old('address') }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="parent_address" class="form-label fw-semibold">Alamat Orang Tua / Wali</label>
                        <textarea name="parent_address" id="parent_address" class="form-control" rows="3" placeholder="Kosongkan jika sama dengan alamat siswa">{{ old('parent_address') }}</textarea>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary-custom px-5 py-2"><i class="bi bi-save me-2"></i> Simpan Data Siswa</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
