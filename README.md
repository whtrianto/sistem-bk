# Update 22 Juni 2026
- Menghapus fitur prestasi 
- Mengubah point default jadi 0
- Menghapus kolom semester di tabel academic_years
- Menyesuaikan tampilan dashboard
- Mengatur reset poin siswa per tahun ajaran 
- Menambah Popup detail pada catatan pelanggaran
- Menambahkan NO. Urut di semua tabel
- jalankan ini di database
```sql
-- 1. Perbarui semua data lama yang sudah terlanjur masuk agar bernilai 0
UPDATE `students` 
SET `initial_points` = 0, 
    `current_points` = 0;

-- 2. Ubah aturan struktur tabel agar data baru ke depannya otomatis bernilai 0
ALTER TABLE `students` 
  MODIFY COLUMN `initial_points` int NOT NULL DEFAULT 0,
  MODIFY COLUMN `current_points` int NOT NULL DEFAULT 0;
```

# Sistem Bimbingan Konseling & Poin Kredit SMK

Sistem Informasi Manajemen Bimbingan Konseling (BK) dan Pencatatan Poin Kredit Kedisiplinan Siswa berbasis web untuk SMK. Sistem ini terintegrasi dengan **WhatsApp Gateway** (Fonnte API) untuk otomatisasi pengiriman notifikasi pelanggaran, pemanggilan orang tua, dan reminder jadwal konseling.

---

## Fitur Utama
1. **Dashboard Khusus Aktor**: Desain modern berbasis *glassmorphic* dengan menu navigasi & infografis grafik (Chart.js) berbeda untuk Admin, Guru BK, Wali Kelas, Kepsek, dan Siswa.
2. **Manajemen Data Master**: Pengelolaan data siswa, kelas, guru, tahun ajaran aktif, serta kategori pelanggaran dan prestasi.
3. **Pencatatan Pelanggaran & Prestasi**: Sistem poin kredit otomatis (pengurangan & penambahan poin) yang terintegrasi dengan WhatsApp Gateway.
4. **Pencatatan Konseling**: Manajemen status sesi BK (Pending, Ongoing, Completed) dengan proteksi kerahasiaan (*Confidentiality*).
5. **Pengajuan Jadwal Mandiri**: Siswa dapat mengajukan *booking* jadwal bimbingan dengan guru BK pilihan melalui sistem.
6. **Generate Surat Panggilan & Cetak PDF**: Cetak kop resmi surat pemanggilan orang tua dalam format PDF (DomPDF) dengan notifikasi digital otomatis.
7. **WhatsApp Gateway Log**: Log pengiriman pesan terintegrasi dengan konsol tes API.

---

## Hak Akses & Alur Kerja (Workflows)

Sistem ini didesain dengan hak akses berbasis peran (*Role-Based Access Control*) yang memisahkan tugas dan alur kerja masing-masing aktor:

### 1. Administrator (Admin)
* **Hak Akses**: Kontrol penuh data master (User, Guru, Siswa, Kelas, Tahun Ajaran), setup konfigurasi sekolah, integrasi WhatsApp Gateway API token, dan monitoring pengiriman log pesan WA.
* **Alur Kerja**: Setup identitas sekolah -> Tambah tahun ajaran & kelas -> Registrasi akun Guru, Wali Kelas, & Siswa -> Monitor kesehatan pengiriman notifikasi WhatsApp.

### 2. Guru Bimbingan Konseling (BK)
* **Hak Akses**: Menginput kasus pelanggaran/prestasi siswa, mengelola catatan sesi konseling, memproses persetujuan booking bimbingan dari siswa, dan memproses pembuatan surat panggilan orang tua.
* **Alur Kerja**:
  * **Input Pelanggaran/Prestasi**: Memilih siswa -> Memilih kategori -> Mengurangi/menambah poin -> Sistem otomatis mengirimkan pesan detail poin ke nomor WhatsApp orang tua.
  * **Sesi Konseling**: Menerima pengajuan bimbingan dari siswa -> Melakukan sesi -> Mengisi catatan masalah, solusi, rencana tindak lanjut, dan memperbarui status sesi menjadi *Completed*.
  * **Surat Panggilan**: Jika akumulasi poin siswa kritis -> Membuat surat panggilan -> Sistem otomatis menyebarkan undangan digital ke nomor WhatsApp orang tua dan mengunduh format surat resmi PDF untuk dicetak.

### 3. Wali Kelas
* **Hak Akses**: Akses baca (*read-only*) terhadap riwayat kedisiplinan dan status konseling siswa yang terdaftar di kelas asuhannya.
* **Alur Kerja**: Login -> Membuka tab "Kelas Saya" -> Memantau akumulasi poin siswa -> Melakukan koordinasi preventif dengan Guru BK apabila ada siswa yang berada di batas threshold poin kritis.

### 4. Siswa
* **Hak Akses**: Memantau saldo poin kredit pribadi secara transparan, melihat kronologi riwayat pelanggaran/prestasi, serta mengajukan bimbingan konseling secara mandiri.
* **Alur Kerja**: Login -> Memantau grafik poin -> Masuk menu "Ajukan Konseling" -> Memilih Guru BK & menentukan jam dan tanggal pertemuan -> Menunggu persetujuan (status *Approved*) dari Guru BK.

### 5. Kepala Sekolah (Kepsek)
* **Hak Akses**: Akses baca (*read-only*) berupa monitoring laporan, komparasi data statistik pelanggaran bulanan, sebaran kategori konseling, dan log keaktifan konseling sekolah.
* **Alur Kerja**: Login -> Memantau grafik tren di Dashboard Kepsek -> Mengunduh rekapitulasi data sebagai bahan evaluasi kebijakan tata tertib sekolah.

---

## Prasyarat Sistem

Sebelum memulai instalasi, pastikan lingkungan lokal Anda memenuhi persyaratan berikut:
* **PHP**: Versi **8.3** atau lebih tinggi (sangat direkomendasikan PHP 8.3.x)
* **Composer**: Versi **2.x** atau lebih baru
* **Node.js & NPM**: Node.js v**18.x** atau v**20.x** (LTS) ke atas
* **Database**: MySQL/MariaDB (dapat menggunakan XAMPP atau Laragon yang menyertakan PHP 8.3+)
* **Ekstensi PHP Terpenting**: Pastikan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `curl`, `xml`, dan `zip` telah aktif di `php.ini`.

---

## Langkah Instalasi (Setup Project)

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi pada server lokal Anda:

### 1. Clone Repositori
Clone project ke direktori lokal Anda (contoh menggunakan XAMPP di `C:\xampp\htdocs\` atau `D:\xampp\htdocs\`):
```bash
git clone https://github.com/whtrianto/sistem-bk.git
cd sistem-bk
```

### 2. Instal Dependensi Backend & Frontend
Instal paket PHP via Composer dan modul NodeJS via NPM:
```bash
# Instal dependensi PHP
composer install

# Instal dependensi Node.js
npm install
```

### 3. Konfigurasi Environment (`.env`)
Salin file `.env.example` menjadi `.env`:
```bash
copy .env.example .env
```
Buka file `.env` dan sesuaikan pengaturan database MySQL Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bk_smk
DB_USERNAME=root
DB_PASSWORD=
```
*(Opsional)* Masukkan token Fonnte Anda untuk menggunakan WhatsApp Gateway:
```env
FONNTE_API_TOKEN=your-token-here
```

### 4. Generate Application Key & Migrasi Database
Jalankan perintah berikut untuk menggenerasikan key Laravel dan memproses migrasi database beserta data seeder awal:
```bash
# Generate Key
php artisan key:generate

# Jalankan Migrasi & Isi Data Awal (Seeder)
php artisan migrate --seed
```

### 5. Kompilasi Aset Frontend (Vite)
Bangun aset CSS dan JS yang telah dikonfigurasi:
```bash
npm run build
```
atau jalankan server pemantau perubahan (development):
```bash
npm run dev
```

### 6. Jalankan Local Server Laravel
Mulai server development PHP:
```bash
php artisan serve
```
Aplikasi kini dapat diakses melalui browser di alamat: `http://127.0.0.1:8000`

---

## Informasi Login (Aktor Pengguna)

Setelah database berhasil di-seed, Anda dapat menggunakan akun demo berikut untuk masuk ke sistem sesuai peran masing-masing (semua akun menggunakan password default: **`password`**):

| No | Peran (Role) | Email | Password | Keterangan Akses |
|----|--------------|-------|----------|-------------------|
| 1 | **Admin** | `admin@smk.sch.id` | `password` | Mengelola data master, setting sekolah, API token, & user akun |
| 2 | **Kepala Sekolah** | `kepsek@smk.sch.id` | `password` | Melihat grafik statistik pelanggaran/prestasi bulanan |
| 3 | **Guru BK (1)** | `guru.bk1@smk.sch.id` | `password` | Pencatatan pelanggaran, prestasi, konseling, & approval jadwal |
| 4 | **Guru BK (2)** | `guru.bk2@smk.sch.id` | `password` | Alternatif akun Guru BK |
| 5 | **Wali Kelas (1)** | `wali.kelas1@smk.sch.id` | `password` | Melihat rekapitulasi poin kelas, pelanggaran, & riwayat konseling |
| 6 | **Wali Kelas (2)** | `wali.kelas2@smk.sch.id` | `password` | Alternatif akun Wali Kelas |
| 7 | **Siswa (1)** | `andi.pratama@siswa.smk.sch.id` | `password` | Melihat sisa poin kedisiplinan & mengajukan jadwal konseling |
| 8 | **Siswa (2)** | `budi.setiawan@siswa.smk.sch.id` | `password` | Alternatif akun Siswa |