@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit SPPD</h5>
                </div>
                <div class="card-body position-relative">
                    @if(session('success'))
                        <!-- Pop-up Notifikasi Sukses -->
                        <style>
                            .success-notification {
                                position: fixed;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                                background: rgba(0, 0, 0, 0.5);
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                z-index: 9999;
                            }
                            .success-modal {
                                background: #22c55e;
                                color: white;
                                padding: 24px;
                                border-radius: 8px;
                                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
                                max-width: 400px;
                                margin: 0 16px;
                                text-align: center;
                            }
                            .success-icon {
                                width: 64px;
                                height: 64px;
                                margin: 0 auto 16px;
                                color: #dcfce7;
                            }
                            .success-title {
                                font-size: 24px;
                                font-weight: bold;
                                margin-bottom: 8px;
                            }
                            .success-message {
                                margin-bottom: 24px;
                                line-height: 1.5;
                            }
                            .close-button {
                                background: #16a34a;
                                color: white;
                                border: none;
                                padding: 8px 24px;
                                border-radius: 9999px;
                                font-weight: 500;
                                cursor: pointer;
                                transition: all 0.3s ease;
                            }
                            .close-button:hover {
                                background: #15803d;
                                transform: scale(1.05);
                                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                            }
                        </style>
                        <div class="success-notification">
                            <div class="success-modal">
                                <div class="success-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="success-title">SPPD Berhasil Diperbarui!</h3>
                                <p class="success-message">{{ session('success') }}</p>
                                <button id="closeBtn" class="close-button">Tutup</button>
                            </div>
                        </div>
                        <script>
                            document.getElementById('closeBtn').onclick = function() {
                                window.location.href = "{{ route('admin.sppd.riwayat') }}";
                            };
                            setTimeout(function() {
                                window.location.href = "{{ route('admin.sppd.riwayat') }}";
                            }, 2000);
                        </script>
                    @endif
                    <form method="POST" action="{{ route('admin.sppd.update', $sppd->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="form-label">Pengguna Anggaran</label>
                            <input type="text" class="form-control" name="pengguna_anggaran" value="{{ old('pengguna_anggaran', $sppd->pengguna_anggaran) }}">
                        </div>
                        <div id="admin-container">
                            @foreach($sppd->nama_pegawai as $i => $nama)
                                                        <div class="row mb-2" id="admin-{{ $i == 0 ? 'pertama' : 'kedua' }}-group">
                                <div class="col-md-3 mb-1">
                                    <label class="form-label">Nama Pegawai</label>
                                    <input type="text" class="form-control" name="nama_pegawai[]" placeholder="Masukkan nama" value="{{ old('nama_pegawai.' . $i, $nama) }}">
                                </div>
                                <div class="col-md-3 mb-1">
                                    <label class="form-label">NIP</label>
                                    <input type="text" class="form-control" name="nip_pegawai[]" placeholder="Masukkan NIP" value="{{ old('nip_pegawai.' . $i, $sppd->nip_pegawai[$i] ?? '') }}">
                                </div>
                                <div class="col-md-3 mb-1">
                                    <label class="form-label">Pangkat/Golongan <small class="text-muted">(Opsional)</small></label>
                                    <input type="text" class="form-control" name="pangkat_golongan[]" placeholder="Masukkan pangkat/golongan (opsional)" value="{{ old('pangkat_golongan.' . $i, $sppd->pangkat_golongan[$i] ?? '') }}">
                                </div>
                                <div class="col-md-3 mb-1">
                                    <label class="form-label">Jabatan/Instansi <small class="text-muted">(Opsional)</small></label>
                                    <input type="text" class="form-control" name="jabatan_pegawai[]" placeholder="Masukkan jabatan/instansi (opsional)" value="{{ old('jabatan_pegawai.' . $i, $sppd->jabatan_pegawai[$i] ?? '') }}">
                                    @if($i == 1)
                                    <button type="button" class="btn btn-outline-danger btn-sm mt-1" id="hapus-admin">Hapus</button>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            <button type="button" class="btn btn-outline-primary btn-sm" id="tambah-admin">Tambah Pegawai</button>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kegiatan</label>
                            <textarea class="form-control" name="kegiatan">{{ old('kegiatan', $sppd->kegiatan) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alat angkut yang dipergunakan</label>
                            <input type="text" class="form-control" name="alat_angkut" value="{{ old('alat_angkut', $sppd->alat_angkut) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tempat Berangkat</label>
                            <input type="text" class="form-control" name="tempat_berangkat" value="{{ old('tempat_berangkat', $sppd->tempat_berangkat) }}">
                        </div>
                        <div class="mb-3" id="tujuan-container">
                            <label class="form-label">Tempat Tujuan</label>
                            @foreach($sppd->tempat_tujuan as $j => $tujuan)
                                <div class="input-group mb-2" id="tujuan-{{ $j == 0 ? 'pertama' : 'kedua' }}-group">
                                    <input type="text" class="form-control" name="tempat_tujuan[]" value="{{ old('tempat_tujuan.' . $j, $tujuan) }}">
                                    @if($j == 1)
                                    <button type="button" class="btn btn-outline-danger" id="hapus-tujuan">Hapus</button>
                                    @endif
                                </div>
                            @endforeach
                            <button type="button" class="btn btn-outline-primary btn-sm" id="tambah-tujuan">Tambah Tujuan</button>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lamanya perjalanan Dinas</label>
                            <input type="text" class="form-control" name="lama_perjalanan" value="{{ old('lama_perjalanan', $sppd->lama_perjalanan) }}">
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Berangkat</label>
                                <input type="date" class="form-control" name="tanggal_berangkat" value="{{ old('tanggal_berangkat', $sppd->tanggal_berangkat ? $sppd->tanggal_berangkat->format('Y-m-d') : '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Pulang</label>
                                <input type="date" class="form-control" name="tanggal_kembali" value="{{ old('tanggal_kembali', $sppd->tanggal_kembali ? $sppd->tanggal_kembali->format('Y-m-d') : '') }}">
                            </div>
                        </div>
                        <div class="mb-3" id="pengikut-container">
                            <label class="form-label">Pengikut / Pendamping</label>
                            @if($sppd->pengikut && count($sppd->pengikut))
                                @foreach($sppd->pengikut as $k => $pengikut)
                                    <div class="row mb-2 align-items-center" id="pengikut-{{ $k == 0 ? 'pertama' : 'kedua' }}-group">
                                        <div class="col-md-7">
                                        <input type="text" class="form-control" name="pengikut[]" value="{{ old('pengikut.' . $k, $pengikut) }}">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="date" class="form-control" name="tanggal_lahir_pengikut[]" placeholder="Tanggal Lahir" value="{{ old('tanggal_lahir_pengikut.' . $k, isset($sppd->tanggal_lahir_pengikut[$k]) ? $sppd->tanggal_lahir_pengikut[$k] : '') }}">
                                        </div>
                                        @if($k == 1)
                                        <div class="col-auto">
                                        <button type="button" class="btn btn-outline-danger" id="hapus-pengikut">Hapus</button>
                                        </div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="row mb-2 align-items-center">
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" name="pengikut[]" value="">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="date" class="form-control" name="tanggal_lahir_pengikut[]" placeholder="Tanggal Lahir">
                                    </div>
                                </div>
                            @endif
                            <button type="button" class="btn btn-outline-primary btn-sm" id="tambah-pengikut">Tambah Pengikut</button>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pembebanan Anggaran</label>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">a. Instansi</label>
                                    <input type="text" class="form-control" name="instansi" value="{{ old('instansi', $sppd->instansi) }}">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">b. Akun</label>
                                    <input type="text" class="form-control" name="akun" value="{{ old('akun', $sppd->akun) }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan (opsional)</label>
                            <textarea class="form-control" name="keterangan">{{ old('keterangan', $sppd->keterangan) }}</textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.sppd.riwayat') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Update SPPD</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Admin (Pegawai)
        const adminContainer = document.getElementById('admin-container');
        const btnTambahAdmin = document.getElementById('tambah-admin');
        btnTambahAdmin.addEventListener('click', function() {
            const count = adminContainer.querySelectorAll('.row.mb-2').length;
            if (count >= 10) return;
            const row = document.createElement('div');
            row.className = 'row mb-2';
            row.innerHTML = `
                <div class='col-md-3 mb-1'>
                    <label class='form-label'>Nama Pegawai</label>
                    <input type='text' class='form-control' name='nama_pegawai[]' placeholder='Masukkan nama'>
                </div>
                <div class='col-md-3 mb-1'>
                    <label class='form-label'>NIP</label>
                    <input type='text' class='form-control' name='nip_pegawai[]' placeholder='Masukkan NIP'>
                </div>
                <div class='col-md-3 mb-1'>
                    <label class='form-label'>Pangkat/Golongan <small class="text-muted">(Opsional)</small></label>
                    <input type='text' class='form-control' name='pangkat_golongan[]' placeholder='Masukkan pangkat/golongan (opsional)'>
                </div>
                <div class='col-md-3 mb-1'>
                    <label class='form-label'>Jabatan/Instansi <small class="text-muted">(Opsional)</small></label>
                    <input type='text' class='form-control' name='jabatan_pegawai[]' placeholder='Masukkan jabatan/instansi (opsional)'>
                    <button type='button' class='btn btn-outline-danger btn-sm hapus-admin mt-1'>Hapus</button>
                </div>
            `;
            adminContainer.insertBefore(row, btnTambahAdmin);
            row.querySelector('.hapus-admin').addEventListener('click', function() {
                row.remove();
            });
        });
        adminContainer.querySelectorAll('.hapus-admin').forEach(btn => {
            btn.addEventListener('click', function() {
                btn.closest('.row.mb-2').remove();
            });
        });
        
        // Tujuan
        const tujuanContainer = document.getElementById('tujuan-container');
        const btnTambahTujuan = document.getElementById('tambah-tujuan');
        btnTambahTujuan.addEventListener('click', function() {
            const count = tujuanContainer.querySelectorAll('input[name="tempat_tujuan[]"]').length;
            if (count >= 10) return;
            const group = document.createElement('div');
            group.className = 'input-group mb-2';
            group.innerHTML = `
                <input type="text" class="form-control" name="tempat_tujuan[]" placeholder="Tempat Tujuan ${count+1}">
                <button type="button" class="btn btn-outline-danger hapus-tujuan">Hapus</button>
            `;
            tujuanContainer.insertBefore(group, btnTambahTujuan);
            group.querySelector('.hapus-tujuan').addEventListener('click', function() {
                group.remove();
            });
        });
        tujuanContainer.querySelectorAll('.hapus-tujuan').forEach(btn => {
            btn.addEventListener('click', function() {
                btn.closest('.input-group.mb-2').remove();
            });
        });
        
        // Pengikut
        const pengikutContainer = document.getElementById('pengikut-container');
        const btnTambahPengikut = document.getElementById('tambah-pengikut');
        btnTambahPengikut.addEventListener('click', function() {
            const count = pengikutContainer.querySelectorAll('input[name="pengikut[]"]').length;
            if (count >= 10) return;
            const group = document.createElement('div');
            group.className = 'row mb-2 align-items-center';
            group.innerHTML = `
                <div class="col-md-7">
                    <input type="text" class="form-control" name="pengikut[]" placeholder="Nama Pengikut">
                </div>
                <div class="col-md-5">
                    <input type="date" class="form-control" name="tanggal_lahir_pengikut[]" placeholder="Tanggal Lahir">
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-outline-danger hapus-pengikut">Hapus</button>
                </div>
            `;
            pengikutContainer.insertBefore(group, btnTambahPengikut);
            group.querySelector('.hapus-pengikut').addEventListener('click', function() {
                group.remove();
            });
        });
        pengikutContainer.querySelectorAll('.hapus-pengikut').forEach(btn => {
            btn.addEventListener('click', function() {
                btn.closest('.row.mb-2').remove();
            });
        });
    });
</script>
@endpush 