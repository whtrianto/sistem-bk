<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Panggilan - {{ $letter->letter_number }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            margin: 0;
            padding: 20px;
        }
        .kop-surat {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }
        .kop-surat h2 {
            margin: 0;
            font-size: 16pt;
            text-transform: uppercase;
        }
        .kop-surat p {
            margin: 5px 0 0 0;
            font-size: 10pt;
        }
        .info-surat {
            margin-bottom: 25px;
        }
        .info-surat table {
            width: 100%;
        }
        .info-surat td {
            vertical-align: top;
        }
        .isi-surat {
            text-align: justify;
            margin-bottom: 25px;
        }
        .detail-pertemuan {
            margin: 20px auto;
            width: 85%;
        }
        .detail-pertemuan table {
            width: 100%;
        }
        .detail-pertemuan td {
            padding: 4px 0;
        }
        .tanda-tangan {
            margin-top: 50px;
            float: right;
            width: 250px;
            text-align: center;
        }
        .tanda-tangan .nama {
            margin-top: 70px;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Kop Surat -->
    <div class="kop-surat">
        <h2>{{ $settings['school_name'] }}</h2>
        <p>{{ $settings['school_address'] }} &bull; Telp: {{ $settings['school_phone'] }}</p>
    </div>

    <!-- Nomor Surat / Perihal -->
    <div class="info-surat">
        <table>
            <tr>
                <td style="width: 12%;">Nomor</td>
                <td style="width: 3%;">:</td>
                <td style="width: 50%;">{{ $letter->letter_number }}</td>
                <td style="text-align: right;">{{ now()->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td>-</td>
                <td></td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td>:</td>
                <td style="font-weight: bold;">Panggilan Orang Tua / Wali Siswa</td>
                <td></td>
            </tr>
        </table>
    </div>

    <!-- Isi Surat -->
    <div class="isi-surat">
        <p>Kepada Yth.<br><strong>Bapak/Ibu Orang Tua / Wali dari {{ $letter->student->user->name }}</strong><br>di Tempat</p>
        
        <p>Dengan hormat,</p>
        <p>Sehubungan dengan adanya hal penting yang perlu dikoordinasikan terkait perkembangan belajar dan kedisiplinan putra/putri Bapak/Ibu di sekolah, dengan ini kami mengharapkan kehadiran Bapak/Ibu pada:</p>
        
        <div class="detail-pertemuan">
            <table>
                <tr>
                    <td style="width: 30%;">Hari / Tanggal</td>
                    <td style="width: 5%;">:</td>
                    <td>{{ $letter->meeting_date->format('l, d F Y') }}</td>
                </tr>
                <tr>
                    <td>Waktu</td>
                    <td>:</td>
                    <td>{{ $letter->meeting_time }} WIB s.d Selesai</td>
                </tr>
                <tr>
                    <td>Tempat</td>
                    <td>:</td>
                    <td>Ruang Bimbingan Konseling (BK) {{ $settings['school_name'] }}</td>
                </tr>
                <tr>
                    <td>Keperluan</td>
                    <td>:</td>
                    <td>{{ $letter->reason }}</td>
                </tr>
            </table>
        </div>

        <p>Mengingat pentingnya koordinasi ini demi masa depan pendidikan putra/putri Bapak/Ibu, kami sangat mengharapkan kehadiran Bapak/Ibu tepat pada waktunya.</p>
        <p>Demikian surat panggilan ini kami sampaikan. Atas perhatian dan kerjasama Bapak/Ibu, kami ucapkan terima kasih.</p>
    </div>

    <!-- Tanda Tangan Kepala Sekolah -->
    <div class="tanda-tangan">
        <p>Kepala Sekolah,</p>
        <div class="nama">{{ $settings['principal_name'] }}</div>
        <div>NIP. {{ $settings['principal_nip'] }}</div>
    </div>
</body>
</html>
