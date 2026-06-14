@extends('layouts.app')

@section('title', 'Pengaturan Sistem')

@section('content')
<div class="container-fluid fade-in-section">
    <div class="mb-4">
        <h3 class="fw-bold text-dark">Pengaturan Sistem</h3>
        <p class="text-muted">Kelola identitas sekolah, parameter poin kredit, dan integrasi WhatsApp Gateway.</p>
    </div>

    <div class="row g-4">
        <!-- Settings Form -->
        <div class="col-lg-8">
            <div class="card border-0 glass-card p-4">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <h5 class="fw-bold mb-3 text-secondary border-bottom pb-2"><i class="bi bi-building-fill text-primary me-2"></i>Profil Sekolah</h5>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 py-2 px-3 mb-3 text-danger" style="background: rgba(239, 68, 68, 0.1); border-radius: 10px; font-size: 14px;">
                            <ul class="m-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="school_name" class="form-label fw-semibold">Nama Sekolah</label>
                            <input type="text" name="school_name" id="school_name" class="form-control" value="{{ $settings['school_name'] ?? '' }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="school_logo" class="form-label fw-semibold">Logo Sekolah</label>
                            <input type="file" name="school_logo" id="school_logo" class="form-control" accept="image/*">
                            <div class="form-text text-muted" style="font-size: 11px;">Format: JPG, PNG, JPEG. Max 2MB.</div>
                        </div>
                    </div>

                    @if($settings['school_logo'] ?? false)
                        <div class="mb-3">
                            <label class="form-label fw-semibold d-block">Logo Saat Ini</label>
                            <div class="d-inline-block p-2 border rounded bg-white">
                                <img src="{{ asset($settings['school_logo']) }}" alt="Logo Sekolah" style="max-height: 80px; object-fit: contain;">
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="school_address" class="form-label fw-semibold">Alamat Sekolah</label>
                        <input type="text" name="school_address" id="school_address" class="form-control" value="{{ $settings['school_address'] ?? '' }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="school_phone" class="form-label fw-semibold">No. Telepon Sekolah</label>
                            <input type="text" name="school_phone" id="school_phone" class="form-control" value="{{ $settings['school_phone'] ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="school_email" class="form-label fw-semibold">Email Sekolah</label>
                            <input type="email" name="school_email" id="school_email" class="form-control" value="{{ $settings['school_email'] ?? '' }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="principal_name" class="form-label fw-semibold">Nama Kepala Sekolah</label>
                            <input type="text" name="principal_name" id="principal_name" class="form-control" value="{{ $settings['principal_name'] ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="principal_nip" class="form-label fw-semibold">NIP Kepala Sekolah</label>
                            <input type="text" name="principal_nip" id="principal_nip" class="form-control" value="{{ $settings['principal_nip'] ?? '' }}">
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3 mt-4 text-secondary border-bottom pb-2"><i class="bi bi-whatsapp text-success me-2"></i>WhatsApp Gateway (Fonnte API)</h5>
                    
                    <div class="mb-3">
                        <label for="wa_api_token" class="form-label fw-semibold">Fonnte API Token</label>
                        <input type="text" name="wa_api_token" id="wa_api_token" class="form-control" placeholder="Masukkan token Fonnte" value="{{ $settings['wa_api_token'] ?? '' }}">
                        <div class="form-text text-muted">Dapatkan API Token dari dashboard <a href="https://fonnte.com" target="_blank">fonnte.com</a>.</div>
                    </div>

                    <div class="mb-3">
                        <label for="wa_api_url" class="form-label fw-semibold">Endpoint API URL</label>
                        <input type="text" name="wa_api_url" id="wa_api_url" class="form-control" value="{{ $settings['wa_api_url'] ?? 'https://api.fonnte.com/send' }}">
                    </div>

                    <h5 class="fw-bold mb-3 mt-4 text-secondary border-bottom pb-2"><i class="bi bi-star-fill text-warning me-2"></i>Parameter Poin Kedisiplinan</h5>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="initial_student_points" class="form-label fw-semibold">Poin Awal Siswa</label>
                            <input type="number" name="initial_student_points" id="initial_student_points" class="form-control" value="{{ $settings['initial_student_points'] ?? 100 }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="warning_point_threshold" class="form-label fw-semibold">Poin Threshold Peringatan</label>
                            <input type="number" name="warning_point_threshold" id="warning_point_threshold" class="form-control" value="{{ $settings['warning_point_threshold'] ?? 50 }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="critical_point_threshold" class="form-label fw-semibold">Poin Threshold Kritis</label>
                            <input type="number" name="critical_point_threshold" id="critical_point_threshold" class="form-control" value="{{ $settings['critical_point_threshold'] ?? 25 }}" required>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary-custom px-4"><i class="bi bi-save me-2"></i> Simpan Pengaturan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- WhatsApp Connection Testing Console -->
        <div class="col-lg-4">
            <div class="card border-0 glass-card p-4 mb-4">
                <h5 class="fw-bold mb-3 text-dark border-bottom pb-2"><i class="bi bi-chat-left-dots-fill text-success me-2"></i>Tes WhatsApp Gateway</h5>
                <form action="{{ route('admin.settings.wa-test') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="phone" class="form-label fw-semibold">Nomor WhatsApp Tujuan</label>
                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Contoh: 081234567890" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label fw-semibold">Isi Pesan Tes</label>
                        <textarea name="message" id="message" class="form-control" rows="3" placeholder="Masukkan isi pesan uji coba..." required>Halo! Ini adalah pesan uji coba integrasi WhatsApp Gateway Fonnte dari Sistem BK SMK.</textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success"><i class="bi bi-send me-2"></i> Kirim Pesan Uji</button>
                    </div>
                </form>
            </div>

            <!-- Settings Quick Notes -->
            <div class="card border-0 glass-card p-4">
                <h5 class="fw-bold mb-3 text-dark border-bottom pb-2"><i class="bi bi-info-circle text-primary me-2"></i>Catatan Gateway</h5>
                <p class="fs-7 text-muted m-0">Setiap pesan pemberitahuan pelanggaran siswa, jadwal konseling, dan surat panggilan orang tua akan menggunakan API Token dan URL yang dikonfigurasi di halaman ini.</p>
            </div>
        </div>
    </div>
</div>
@endsection
