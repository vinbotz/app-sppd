<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SPPD Terbaru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .page-break { page-break-before: always; }
        .header { width: 100%; margin-bottom: 5px; }
        .header td { border: none; }
                 .header-title { font-size: 16px; font-weight: bold; text-align: center; line-height: 1.4; }
         .header-subtitle { font-size: 11px; text-align: center; line-height: 1.3; }
        .header-divider { border-bottom: 1px solid #000; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        td { border: 1px solid #000; padding: 4px; vertical-align: top; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
        .border-none { border: none; }
        .border-bottom { border-bottom: 1px solid #000; }
        .border-top { border-top: 1px solid #000; }
        .border-left { border-left: 1px solid #000; }
        .border-right { border-right: 1px solid #000; }
        .no-padding { padding: 0; }
        .small-text { font-size: 10px; }
        .medium-text { font-size: 11px; }
        .large-text { font-size: 13px; }
                 .logo { width: 80px; height: 80px; }
         .header-left { width: 100px; vertical-align: top; }
         .header-right { vertical-align: top; }
    </style>
</head>
<body>
    <!-- Halaman Pertama (SURAT PERJALANAN DINAS) -->
<table class="header">
    <tr>
            <td class="header-left">
                <img src="{{ public_path('img/logo-kota-bogor.png') }}" class="logo" alt="Logo Kota Bogor">
        </td>
            <td class="header-right">
            <div class="header-title">PEMERINTAH KOTA BOGOR<br>SEKRETARIAT DPRD KOTA BOGOR</div>
            <div class="header-subtitle">: Jl. Pemuda No.25, RT.01/RW.06, Tanah Sareal, Kec. Tanah Sereal, Kota Bogor, Jawa Barat 16161. (0251) 8323472 Faks (0251) 8361108</div>
        </td>
    </tr>
</table>
    <div class="header-divider"></div>

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px;">
        <tr>
            <td class="text-center border-none" style="font-size: 14px; font-weight: bold;">
                SURAT PERJALANAN DINAS
            </td>
    </tr>
    <tr>
            <td class="text-center border-none" style="font-size: 12px;">
                Nomor: {{ isset($sppdList[0]) ? ($sppdList[0]->nomor_sppd ?? '000.1.2.2 / 1399 - 1400 / Banmus') : '000.1.2.2 / 1399 - 1400 / Banmus' }}
        </td>
    </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 25%; border: 1px solid #000; padding: 4px;">1. Pengguna Anggaran</td>
            <td style="width: 5%; border: 1px solid #000; padding: 4px;">:</td>
            <td style="width: 70%; border: 1px solid #000; padding: 4px;">{{ isset($sppdList[0]) ? ($sppdList[0]->pengguna_anggaran ?? 'Dwi Roman Pujo Prasetyo, S.H., M.M.') : 'Dwi Roman Pujo Prasetyo, S.H., M.M.' }}</td>
    </tr>
    <tr>
             <td style="border: 1px solid #000; padding: 4px;">2. Nama Pegawai yang melaksanakan perjalanan Dinas</td>
             <td style="border: 1px solid #000; padding: 4px;">:</td>
             <td style="border: 1px solid #000; padding: 4px;">{{ isset($sppdList[0]) && is_array($sppdList[0]->nama_pegawai) ? ($sppdList[0]->nama_pegawai[0] ?? 'Hj. Hakana, S.I.Kom.,M.A.P.') : ($sppdList[0]->nama_pegawai ?? 'Hj. Hakana, S.I.Kom.,M.A.P.') }}</td>
    </tr>
    <tr>
             <td style="border: 1px solid #000; padding: 4px;">3. NIP</td>
             <td style="border: 1px solid #000; padding: 4px;">:</td>
             <td style="border: 1px solid #000; padding: 4px;">{{ isset($sppdList[0]) && is_array($sppdList[0]->nip_pegawai) ? ($sppdList[0]->nip_pegawai[0] ?? '197001011990032001') : ($sppdList[0]->nip_pegawai ?? '197001011990032001') }}</td>
    </tr>
    <tr>
             <td style="border: 1px solid #000; padding: 4px;">4. a. Pangkat/golongan<br>&nbsp;&nbsp;&nbsp;&nbsp;b. Jabatan/instansi</td>
             <td style="border: 1px solid #000; padding: 4px;">:</td>
             <td style="border: 1px solid #000; padding: 4px;">a. {{ isset($sppdList[0]) && is_array($sppdList[0]->pangkat_golongan) ? ($sppdList[0]->pangkat_golongan[0] ?? '-') : ($sppdList[0]->pangkat_golongan ?? '-') }}<br>b. {{ isset($sppdList[0]) && is_array($sppdList[0]->jabatan_pegawai) ? ($sppdList[0]->jabatan_pegawai[0] ?? 'Anggota Badan Musyawarah/DPRD Kota Bogor') : ($sppdList[0]->jabatan_pegawai ?? 'Anggota Badan Musyawarah/DPRD Kota Bogor') }}</td>
    </tr>
    <tr>
             <td style="border: 1px solid #000; padding: 4px;">5. Maksud perjalanan dinas</td>
             <td style="border: 1px solid #000; padding: 4px;">:</td>
             <td style="border: 1px solid #000; padding: 4px;">{{ isset($sppdList[0]) ? ($sppdList[0]->kegiatan ?? 'Dalam rangka Konsultasi dan Koordinasi Badan Musyawarah Dalam rangka Memperoleh Informasi Terkait Tabtabfab Apa Saja Yang Sering Dihadapi Badan Musyawarah Dalam Melaksanakan Tugas-tugasnya.') : 'Dalam rangka Konsultasi dan Koordinasi Badan Musyawarah Dalam rangka Memperoleh Informasi Terkait Tabtabfab Apa Saja Yang Sering Dihadapi Badan Musyawarah Dalam Melaksanakan Tugas-tugasnya.' }}</td>
    </tr>
    <tr>
             <td style="border: 1px solid #000; padding: 4px;">6. Alat angkut yang dipergunakan</td>
             <td style="border: 1px solid #000; padding: 4px;">:</td>
             <td style="border: 1px solid #000; padding: 4px;">{{ isset($sppdList[0]) ? ($sppdList[0]->alat_angkut ?? '') : '' }}</td>
    </tr>
    <tr>
             <td style="border: 1px solid #000; padding: 4px;">7. a. Tempat Berangkat<br>&nbsp;&nbsp;&nbsp;&nbsp;b. Tempat Tujuan</td>
             <td style="border: 1px solid #000; padding: 4px;">:</td>
             <td style="border: 1px solid #000; padding: 4px;">a. {{ isset($sppdList[0]) ? ($sppdList[0]->tempat_berangkat ?? 'DPRD Kota Bogor') : 'DPRD Kota Bogor' }}<br>b. {{ isset($sppdList[0]) && is_array($sppdList[0]->tempat_tujuan) ? ($sppdList[0]->tempat_tujuan[0] ?? 'DPRD Kabupaten Bogor') : ($sppdList[0]->tempat_tujuan ?? 'DPRD Kabupaten Bogor') }}</td>
    </tr>
    <tr>
             <td style="border: 1px solid #000; padding: 4px;">8. a. Lamanya perjalanan Dinas<br>&nbsp;&nbsp;&nbsp;&nbsp;b. Tanggal Berangkat<br>&nbsp;&nbsp;&nbsp;&nbsp;c. Tanggal harus kembali/tiba di tempat baru</td>
             <td style="border: 1px solid #000; padding: 4px;">:</td>
             <td style="border: 1px solid #000; padding: 4px;">a. {{ isset($sppdList[0]) ? ($sppdList[0]->lama_perjalanan ?? '3 hari') : '3 hari' }}<br>b. {{ isset($sppdList[0]) && $sppdList[0]->tanggal_berangkat ? \Carbon\Carbon::parse($sppdList[0]->tanggal_berangkat)->format('d F Y') : '29 Juni 2025' }}<br>c. {{ isset($sppdList[0]) && $sppdList[0]->tanggal_kembali ? \Carbon\Carbon::parse($sppdList[0]->tanggal_kembali)->format('d F Y') : '01 Juli 2025' }}</td>
    </tr>
    <tr>
             <td style="border: 1px solid #000; padding: 4px;">9. Pengikut : Nama</td>
             <td style="border: 1px solid #000; padding: 4px;">:</td>
             <td style="border: 1px solid #000; padding: 4px;">
                 <table style="width: 100%; border-collapse: collapse;">
                     <tr>
                         <td style="border: 1px solid #000; padding: 2px; width: 50%;">Tanggal Lahir</td>
                         <td style="border: 1px solid #000; padding: 2px; width: 50%;">Nama</td>
                </tr>
                     @if(isset($sppdList[0]) && is_array($sppdList[0]->pengikut) && count($sppdList[0]->pengikut) > 0)
                         @foreach($sppdList[0]->pengikut as $i => $pengikut)
                             <tr>
                                 <td style="border: 1px solid #000; padding: 2px; height: 20px;">
                                     @if(isset($sppdList[0]->tanggal_lahir_pengikut[$i]) && $sppdList[0]->tanggal_lahir_pengikut[$i])
                                         {{ \Carbon\Carbon::parse($sppdList[0]->tanggal_lahir_pengikut[$i])->format('d-m-Y') }}
                            @endif
                        </td>
                                 <td style="border: 1px solid #000; padding: 2px; height: 20px;">{{ $pengikut }}</td>
                    </tr>
                    @endforeach
                         @for($i = count($sppdList[0]->pengikut); $i < 4; $i++)
                             <tr>
                                 <td style="border: 1px solid #000; padding: 2px; height: 20px;"></td>
                                 <td style="border: 1px solid #000; padding: 2px; height: 20px;"></td>
                             </tr>
                    @endfor
                @else
                         <tr>
                             <td style="border: 1px solid #000; padding: 2px; height: 20px;"></td>
                             <td style="border: 1px solid #000; padding: 2px; height: 20px;"></td>
                         </tr>
                         <tr>
                             <td style="border: 1px solid #000; padding: 2px; height: 20px;"></td>
                             <td style="border: 1px solid #000; padding: 2px; height: 20px;"></td>
                         </tr>
                         <tr>
                             <td style="border: 1px solid #000; padding: 2px; height: 20px;"></td>
                             <td style="border: 1px solid #000; padding: 2px; height: 20px;"></td>
                         </tr>
                         <tr>
                             <td style="border: 1px solid #000; padding: 2px; height: 20px;"></td>
                             <td style="border: 1px solid #000; padding: 2px; height: 20px;"></td>
                         </tr>
                @endif
            </table>
        </td>
    </tr>
    <tr>
             <td style="border: 1px solid #000; padding: 4px;">10. a. Instansi<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b. Akun</td>
             <td style="border: 1px solid #000; padding: 4px;">:</td>
             <td style="border: 1px solid #000; padding: 4px;">a. {{ isset($sppdList[0]) ? ($sppdList[0]->instansi ?? 'Sekretariat DPRD') : 'Sekretariat DPRD' }}<br>b. {{ isset($sppdList[0]) ? ($sppdList[0]->akun ?? '5.2.2.15.02') : '5.2.2.15.02' }}</td>
    </tr>
    <tr>
             <td style="border: 1px solid #000; padding: 4px;">11. Keterangan lain-lain</td>
             <td style="border: 1px solid #000; padding: 4px;">:</td>
             <td style="border: 1px solid #000; padding: 4px;">{{ isset($sppdList[0]) ? ($sppdList[0]->keterangan ?? '') : '' }}</td>
    </tr>
</table>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
    <tr>
            <td style="width: 60%; border: none; padding: 4px;"></td>
            <td style="width: 40%; border: none; padding: 4px; text-align: center;">
            Dikeluarkan di Bogor<br>
                Tanggal {{ isset($sppdList[0]) && $sppdList[0]->tanggal_sppd ? \Carbon\Carbon::parse($sppdList[0]->tanggal_sppd)->format('d F Y') : '29 Juni 2025' }}<br>
            Pengguna Anggaran,<br><br><br><br>
                <span style="font-weight: bold;">{{ isset($sppdList[0]) ? ($sppdList[0]->pengguna_anggaran ?? 'Dwi Roman Pujo Prasetyo, S.H., M.M.') : 'Dwi Roman Pujo Prasetyo, S.H., M.M.' }}</span><br>
                NIP. {{ isset($sppdList[0]) ? ($sppdList[0]->nip_pengguna_anggaran ?? '195807161993031001') : '195807161993031001' }}
        </td>
    </tr>
</table>

    <!-- Halaman Kedua (Form Verifikasi) -->
    <div class="page-break">

        
        <!-- Section II -->
        <div style="margin-bottom: 15px;">
            <h3 style="font-weight: bold; margin-bottom: 10px;">II Tiba di:</h3>
            <div style="margin-left: 20px;">
                <div style="margin-bottom: 5px;">Berangkat dari : <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; height: 15px;"></span></div>
                <div style="margin-bottom: 5px;">Ke : <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; height: 15px;"></span></div>
                <div style="margin-bottom: 5px;">Pada Tanggal : <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; height: 15px;"></span></div>
                <div style="margin-bottom: 5px;">Kepala : <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; height: 15px;"></span></div>
            </div>
        </div>

        <!-- Section III -->
        <div style="margin-bottom: 15px;">
            <h3 style="font-weight: bold; margin-bottom: 10px;">III Tiba di:</h3>
            <div style="margin-left: 20px;">
                <div style="margin-bottom: 5px;">Berangkat dari : <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; height: 15px;"></span></div>
                <div style="margin-bottom: 5px;">Ke : <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; height: 15px;"></span></div>
                <div style="margin-bottom: 5px;">Pada Tanggal : <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; height: 15px;"></span></div>
                <div style="margin-bottom: 5px;">Kepala : <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; height: 15px;"></span></div>
            </div>
        </div>

        <!-- Section IV -->
        <div style="margin-bottom: 15px;">
            <h3 style="font-weight: bold; margin-bottom: 10px;">IV Tiba di:</h3>
            <div style="margin-left: 20px;">
                <div style="margin-bottom: 5px;">Berangkat dari : <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; height: 15px;"></span></div>
                <div style="margin-bottom: 5px;">Ke : <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; height: 15px;"></span></div>
                <div style="margin-bottom: 5px;">Pada Tanggal : <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; height: 15px;"></span></div>
                <div style="margin-bottom: 5px;">Kepala : <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; height: 15px;"></span></div>
            </div>
        </div>

        <!-- Section V -->
        <div style="margin-bottom: 15px;">
            <h3 style="font-weight: bold; margin-bottom: 10px;">V Tiba di:</h3>
            <div style="margin-left: 20px;">
                <div style="margin-bottom: 5px;">Berangkat dari : <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; height: 15px;"></span></div>
                <div style="margin-bottom: 5px;">Ke : <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; height: 15px;"></span></div>
                <div style="margin-bottom: 5px;">Pada Tanggal : <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; height: 15px;"></span></div>
                <div style="margin-bottom: 5px;">Kepala : <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; height: 15px;"></span></div>
            </div>
        </div>

        <!-- Section VI -->
        <div style="margin-bottom: 15px;">
            <h3 style="font-weight: bold; margin-bottom: 10px;">VI Tiba di:</h3>
            <div style="margin-left: 20px;">
                <div style="margin-bottom: 5px;">Berangkat dari : <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; height: 15px;"></span></div>
                <div style="margin-bottom: 5px;">Ke : <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; height: 15px;"></span></div>
                <div style="margin-bottom: 5px;">Pada Tanggal : <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; height: 15px;"></span></div>
                <div style="margin-bottom: 5px;">Kepala : <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; height: 15px;"></span></div>
            </div>
        </div>

        <!-- Verifikasi Text -->
        <div style="margin-top: 30px; margin-bottom: 20px;">
            <p style="text-align: justify; line-height: 1.5;">
                Telah diperiksa dengan keterangan bahwa perjalanan tersebut atas perintahnya dan semata-mata untuk kepentingan jabatan dalam waktu sesingkat-singkatnya.
            </p>
        </div>

        <!-- Pengguna Anggaran -->
        <div style="margin-top: 20px;">
            <div style="margin-bottom: 10px;">Pengguna Anggaran:</div>
            <div style="margin-left: 20px; margin-top: 30px;">
                <span style="border-bottom: 1px solid #000; display: inline-block; width: 300px; height: 15px;"></span>
                <span style="margin-left: 10px;">(...........................)</span>
            </div>
        </div>
    </div>
</body>
</html>