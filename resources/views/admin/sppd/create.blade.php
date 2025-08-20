@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="success-notification-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); display: flex; align-items: center; justify-content: center; z-index: 9999;">
        <div class="success-modal-content" style="background: white; border-radius: 1rem; padding: 2rem; text-align: center; max-width: 400px; margin: 0 1rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
            <div class="success-circle mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #22c55e, #16a34a); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-check text-white" style="font-size: 2rem;"></i>
            </div>
            <h3 class="text-success fw-bold mb-2" style="font-size: 1.5rem;">SPPD Berhasil Diajukan</h3>
            <p class="text-muted mb-0">{{ session('success') }}</p>
        </div>
    </div>
    <script>
        setTimeout(function() {
            var notif = document.querySelector('.success-notification-overlay');
            if (notif) {
                notif.style.opacity = '0';
                notif.style.transition = 'opacity 0.3s ease';
                setTimeout(function() { window.location.href = "{{ route('admin.sppd.riwayat') }}"; }, 300);
            } else {
                window.location.href = "{{ route('admin.sppd.riwayat') }}";
            }
        }, 3000);
    </script>
@endif
<style>
    /* Styling untuk menonjolkan garis pengisian per kolom */
    .form-control {
        border: 2px solid #e0e0e0 !important;
        border-radius: 8px !important;
        padding: 12px 15px !important;
        font-size: 14px !important;
        transition: all 0.3s ease !important;
        background-color: #fafafa !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05) !important;
    }
    
    .form-control:focus {
        border-color: #2196f3 !important;
        box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1) !important;
        background-color: #ffffff !important;
        outline: none !important;
    }
    
    .form-control:hover {
        border-color: #2196f3 !important;
        background-color: #ffffff !important;
    }
    
    /* Styling khusus untuk textarea */
    textarea.form-control {
        min-height: 100px !important;
        resize: vertical !important;
    }
    
    /* Styling untuk input date */
    input[type="date"].form-control {
        position: relative !important;
    }
    
    /* Styling untuk label */
    .form-label {
        font-weight: 600 !important;
        color: #333 !important;
        margin-bottom: 8px !important;
        font-size: 14px !important;
    }
    
    /* Styling untuk container input */
    .mb-3 {
        margin-bottom: 20px !important;
    }
    
    /* Styling untuk row input pegawai */
    .row.mb-2 {
        background: #f8f9fa !important;
        padding: 15px !important;
        border-radius: 10px !important;
        border: 1px solid #e9ecef !important;
        margin-bottom: 10px !important;
    }
    
    /* Styling untuk button */
    .btn {
        border-radius: 8px !important;
        font-weight: 500 !important;
        padding: 10px 20px !important;
        transition: all 0.3s ease !important;
    }
    
    .btn-primary {
        background: linear-gradient(90deg, #1976d2 0%, #21cbf3 100%) !important;
        border: none !important;
        box-shadow: 0 4px 12px rgba(25, 118, 210, 0.3) !important;
    }
    
    .btn-primary:hover {
        background: linear-gradient(90deg, #1565c0 0%, #1de9b6 100%) !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(25, 118, 210, 0.4) !important;
    }
    
    .btn-outline-primary {
        border-color: #2196f3 !important;
        color: #2196f3 !important;
    }
    
    .btn-outline-primary:hover {
        background-color: #2196f3 !important;
        border-color: #2196f3 !important;
        color: white !important;
    }
    
    .btn-outline-danger {
        border-color: #dc3545 !important;
        color: #dc3545 !important;
    }
    
    .btn-outline-danger:hover {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
        color: white !important;
    }
    
    /* Styling untuk card */
    .card {
        border: none !important;
        box-shadow: 0 8px 32px rgba(0,0,0,0.1) !important;
        border-radius: 15px !important;
    }
    
    .card-header {
        background: linear-gradient(120deg, #2196f3 0%, #e3f0fc 100%) !important;
        border-bottom: none !important;
        border-radius: 15px 15px 0 0 !important;
        padding: 20px 25px !important;
    }
    
    .card-header h5 {
        color: #1976d2 !important;
        font-weight: 700 !important;
        margin: 0 !important;
    }
    
    .card-body {
        padding: 30px !important;
    }
</style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Buat SPPD Baru</h5>
                    </div>

                    <div class="card-body position-relative">
                    @if(session('submitted'))
                        <!-- Modal Success -->
                        <div class="modal fade show" id="successModal" tabindex="-1" aria-modal="true" role="dialog" style="display:block; background:rgba(0,0,0,0.3);">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content text-center p-4 border-0" style="background:transparent;box-shadow:none;">
                                    <div class="bg-white rounded-4 p-4 shadow-lg d-flex flex-column align-items-center">
                                        <svg width="90" height="90" viewBox="0 0 80 80">
                                            <circle cx="40" cy="40" r="38" fill="#e6f9ed" stroke="#34c759" stroke-width="4"/>
                                            <polyline points="25,43 37,55 57,30" fill="none" stroke="#34c759" stroke-width="6" stroke-linecap="round" stroke-linejoin="round">
                                                <animate attributeName="points" dur="0.5s" to="25,43 37,55 57,30" fill="freeze" />
                                            </polyline>
                                        </svg>
                                        <h4 class="mt-3 text-success fw-bold">SPPD berhasil diajukan</h4>
                                        <div class="text-muted">{{ session('submitted') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            setTimeout(function() {
                                window.location.reload();
                            }, 2500);
                        </script>
                    @endif
                    <form method="POST" action="{{ route('admin.sppd.store') }}" @if(session('submitted')) style="opacity:0.2;pointer-events:none;user-select:none;" @endif>
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Pengguna Anggaran</label>
                                <input type="text" class="form-control" name="pengguna_anggaran" value="{{ is_array(old('pengguna_anggaran')) ? '' : old('pengguna_anggaran') }}">
                            </div>
                            <div id="admin-container">
                                                            <div class="row mb-2" id="admin-pertama-group">
                                <div class="col-md-3 mb-1">
                                    <label class="form-label">Nama Pegawai</label>
                                    <input type="text" class="form-control" name="nama_pegawai[]" placeholder="Masukkan nama" value="{{ is_array(old('nama_pegawai.0')) ? '' : old('nama_pegawai.0') }}">
                                </div>
                                <div class="col-md-3 mb-1">
                                    <label class="form-label">NIP</label>
                                    <input type="text" class="form-control" name="nip_pegawai[]" placeholder="Masukkan NIP" value="{{ is_array(old('nip_pegawai.0')) ? '' : old('nip_pegawai.0') }}">
                                </div>
                                <div class="col-md-3 mb-1">
                                    <label class="form-label">Pangkat/Golongan <small class="text-muted">(Opsional)</small></label>
                                    <input type="text" class="form-control" name="pangkat_golongan[]" placeholder="Masukkan pangkat/golongan (opsional)" value="{{ is_array(old('pangkat_golongan.0')) ? '' : old('pangkat_golongan.0') }}">
                                </div>
                                <div class="col-md-3 mb-1">
                                    <label class="form-label">Jabatan/Instansi <small class="text-muted">(Opsional)</small></label>
                                    <input type="text" class="form-control" name="jabatan_pegawai[]" placeholder="Masukkan jabatan/instansi (opsional)" value="{{ is_array(old('jabatan_pegawai.0')) ? '' : old('jabatan_pegawai.0') }}">
                                </div>
                            </div>
                                @if(old('nama_pegawai.1') || old('nip_pegawai.1') || old('jabatan_pegawai.1'))
                                                                <div class="row mb-2" id="admin-kedua-group">
                                <div class="col-md-3 mb-1">
                                    <label class="form-label">Nama Pegawai</label>
                                    <input type="text" class="form-control" name="nama_pegawai[]" placeholder="Masukkan nama" value="{{ is_array(old('nama_pegawai.1')) ? '' : old('nama_pegawai.1') }}">
                                </div>
                                <div class="col-md-3 mb-1">
                                    <label class="form-label">NIP</label>
                                    <input type="text" class="form-control" name="nip_pegawai[]" placeholder="Masukkan NIP" value="{{ is_array(old('nip_pegawai.1')) ? '' : old('nip_pegawai.1') }}">
                                </div>
                                <div class="col-md-3 mb-1">
                                    <label class="form-label">Pangkat/Golongan <small class="text-muted">(Opsional)</small></label>
                                    <input type="text" class="form-control" name="pangkat_golongan[]" placeholder="Masukkan pangkat/golongan (opsional)" value="{{ is_array(old('pangkat_golongan.1')) ? '' : old('pangkat_golongan.1') }}">
                                </div>
                                <div class="col-md-3 mb-1">
                                    <label class="form-label">Jabatan/Instansi</label>
                                    <input type="text" class="form-control" name="jabatan_pegawai[]" placeholder="Masukkan jabatan/instansi" value="{{ is_array(old('jabatan_pegawai.1')) ? '' : old('jabatan_pegawai.1') }}">
                                    <button type="button" class="btn btn-outline-danger btn-sm mt-1" id="hapus-admin">Hapus</button>
                                </div>
                            </div>
                                @endif
                                <button type="button" class="btn btn-outline-primary btn-sm" id="tambah-admin">Tambah Pegawai</button>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kegiatan</label>
                                <textarea class="form-control" name="kegiatan">{{ is_array(old('kegiatan')) ? '' : old('kegiatan') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alat angkut yang dipergunakan</label>
                                <input type="text" class="form-control" name="alat_angkut" value="{{ is_array(old('alat_angkut')) ? '' : old('alat_angkut') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tempat Berangkat</label>
                                <input type="text" class="form-control" name="tempat_berangkat" value="{{ is_array(old('tempat_berangkat')) ? '' : old('tempat_berangkat') }}">
                            </div>
                            <div class="mb-3" id="tujuan-container">
                                <label class="form-label">Tempat Tujuan</label>
                                <input type="text" class="form-control mb-2" name="tempat_tujuan[]" value="{{ is_array(old('tempat_tujuan.0')) ? '' : old('tempat_tujuan.0') }}">
                                @if(old('tempat_tujuan.1'))
                                <div class="input-group mb-2" id="tujuan-kedua-group">
                                    <input type="text" class="form-control" name="tempat_tujuan[]" value="{{ is_array(old('tempat_tujuan.1')) ? '' : old('tempat_tujuan.1') }}">
                                    <button type="button" class="btn btn-outline-danger" id="hapus-tujuan">Hapus</button>
                                </div>
                                @endif
                                <button type="button" class="btn btn-outline-primary btn-sm" id="tambah-tujuan">Tambah Tujuan</button>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Lamanya perjalanan Dinas</label>
                                <input type="text" class="form-control" name="lama_perjalanan" value="{{ is_array(old('lama_perjalanan')) ? '' : old('lama_perjalanan') }}">
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Berangkat</label>
                                    <input type="date" class="form-control" name="tanggal_berangkat" value="{{ is_array(old('tanggal_berangkat')) ? '' : old('tanggal_berangkat') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Pulang</label>
                                    <input type="date" class="form-control" name="tanggal_kembali" value="{{ is_array(old('tanggal_kembali')) ? '' : old('tanggal_kembali') }}">
                                </div>
                            </div>
                            <div class="mb-3" id="pengikut-container">
                                <label class="form-label">Pengikut / Pendamping</label>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Pengikut</label>
                                        <input type="text" class="form-control" name="pengikut[]" placeholder="Nama Pengikut" value="{{ is_array(old('pengikut.0')) ? '' : old('pengikut.0') }}">
                                    </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir Pengikut</label>
                                        <input type="date" class="form-control" name="tanggal_lahir_pengikut[]" placeholder="Tanggal Lahir" value="{{ is_array(old('tanggal_lahir_pengikut.0')) ? '' : old('tanggal_lahir_pengikut.0') }}">
                                    </div>
                                </div>
                            @if(old('pengikut.1'))
                            <div class="row mb-2" id="pengikut-kedua-group">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Pengikut</label>
                                        <input type="text" class="form-control" name="pengikut[]" placeholder="Nama Pengikut" value="{{ is_array(old('pengikut.1')) ? '' : old('pengikut.1') }}">
                                    </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir Pengikut</label>
                                    <div class="d-flex align-items-end gap-2">
                                        <input type="date" class="form-control" name="tanggal_lahir_pengikut[]" placeholder="Tanggal Lahir" value="{{ is_array(old('tanggal_lahir_pengikut.1')) ? '' : old('tanggal_lahir_pengikut.1') }}">
                                        <button type="button" class="btn btn-outline-danger" id="hapus-pengikut">Hapus</button>
                                    </div>
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
                                        <input type="text" class="form-control" name="instansi" value="{{ is_array(old('instansi')) ? '' : old('instansi') }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">b. Akun</label>
                                        <input type="text" class="form-control" name="akun" value="{{ is_array(old('akun')) ? '' : old('akun') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan (opsional)</label>
                                <textarea class="form-control" name="keterangan">{{ is_array(old('keterangan')) ? '' : old('keterangan') }}</textarea>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.sppd.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan SPPD</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Modal Notifikasi Wajib Isi -->
<div class="modal fade" id="modalWajibIsi" tabindex="-1" aria-labelledby="modalWajibIsiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning-subtle">
        <h5 class="modal-title text-warning" id="modalWajibIsiLabel"><i class="fas fa-exclamation-triangle me-2"></i>Data Tidak Lengkap</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul id="listWajibIsi" class="mb-0"></ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
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
            group.className = 'row mb-2';
            group.innerHTML = `
                <div class="col-md-6">
                    <label class="form-label">Nama Pengikut</label>
                    <input type="text" class="form-control" name="pengikut[]" placeholder="Nama Pengikut ${count+1}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Lahir Pengikut</label>
                    <div class="d-flex align-items-end gap-2">
                    <input type="date" class="form-control" name="tanggal_lahir_pengikut[]" placeholder="Tanggal Lahir">
                        <button type="button" class="btn btn-outline-danger hapus-pengikut">Hapus</button>
                </div>
                </div>
            `;
            pengikutContainer.insertBefore(group, btnTambahPengikut);
            group.querySelector('.hapus-pengikut').addEventListener('click', function() {
                group.remove();
            });
        });
        pengikutContainer.querySelectorAll('.hapus-pengikut').forEach(btn => {
            btn.addEventListener('click', function() {
                btn.closest('.input-group.mb-2').remove();
            });
        });
        // Validasi wajib isi saat submit
        const form = document.querySelector('form[action="{{ route('admin.sppd.store') }}"]');
        form.addEventListener('submit', function(e) {
            let valid = true;
            // Reset error
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

            // Pengguna Anggaran
            const penggunaAnggaran = form.querySelector('[name="pengguna_anggaran"]');
            if (!penggunaAnggaran.value.trim()) {
                penggunaAnggaran.classList.add('is-invalid');
                penggunaAnggaran.insertAdjacentHTML('afterend', '<div class="invalid-feedback d-block">*kolom wajib diisi</div>');
                valid = false;
            }
            // Nama/NIP/Jabatan Admin
            const namaAdmin = form.querySelectorAll('[name="nama_pegawai[]"]');
            const nipAdmin = form.querySelectorAll('[name="nip_pegawai[]"]');
            const jabatanAdmin = form.querySelectorAll('[name="jabatan_pegawai[]"]');
            namaAdmin.forEach((el, i) => {
                if (!el.value.trim()) {
                    el.classList.add('is-invalid');
                    el.insertAdjacentHTML('afterend', '<div class="invalid-feedback d-block">*kolom wajib diisi</div>');
                    valid = false;
                }
                if (!nipAdmin[i].value.trim()) {
                    nipAdmin[i].classList.add('is-invalid');
                    nipAdmin[i].insertAdjacentHTML('afterend', '<div class="invalid-feedback d-block">*kolom wajib diisi</div>');
                    valid = false;
                }
                if (!jabatanAdmin[i].value.trim()) {
                    jabatanAdmin[i].classList.add('is-invalid');
                    jabatanAdmin[i].insertAdjacentHTML('afterend', '<div class="invalid-feedback d-block">*kolom wajib diisi</div>');
                    valid = false;
                }
            });
            // Kegiatan
            const kegiatan = form.querySelector('[name="kegiatan"]');
            if (!kegiatan.value.trim()) {
                kegiatan.classList.add('is-invalid');
                kegiatan.insertAdjacentHTML('afterend', '<div class="invalid-feedback d-block">*kolom wajib diisi</div>');
                valid = false;
            }
            // Alat Angkut
            const alatAngkut = form.querySelector('[name="alat_angkut"]');
            if (!alatAngkut.value.trim()) {
                alatAngkut.classList.add('is-invalid');
                alatAngkut.insertAdjacentHTML('afterend', '<div class="invalid-feedback d-block">*kolom wajib diisi</div>');
                valid = false;
            }
            // Tempat Berangkat
            const tempatBerangkat = form.querySelector('[name="tempat_berangkat"]');
            if (!tempatBerangkat.value.trim()) {
                tempatBerangkat.classList.add('is-invalid');
                tempatBerangkat.insertAdjacentHTML('afterend', '<div class="invalid-feedback d-block">*kolom wajib diisi</div>');
                valid = false;
            }
            // Tempat Tujuan
            const tempatTujuan = form.querySelectorAll('[name="tempat_tujuan[]"]');
            tempatTujuan.forEach(el => {
                if (!el.value.trim()) {
                    el.classList.add('is-invalid');
                    el.insertAdjacentHTML('afterend', '<div class="invalid-feedback d-block">*kolom wajib diisi</div>');
                    valid = false;
                }
            });
            // Lama Perjalanan
            const lamaPerjalanan = form.querySelector('[name="lama_perjalanan"]');
            if (!lamaPerjalanan.value.trim()) {
                lamaPerjalanan.classList.add('is-invalid');
                lamaPerjalanan.insertAdjacentHTML('afterend', '<div class="invalid-feedback d-block">*kolom wajib diisi</div>');
                valid = false;
            }
            // Tanggal Berangkat
            const tanggalBerangkat = form.querySelector('[name="tanggal_berangkat"]');
            if (!tanggalBerangkat.value.trim()) {
                tanggalBerangkat.classList.add('is-invalid');
                tanggalBerangkat.insertAdjacentHTML('afterend', '<div class="invalid-feedback d-block">*kolom wajib diisi</div>');
                valid = false;
            }
            // Tanggal Kembali
            const tanggalKembali = form.querySelector('[name="tanggal_kembali"]');
            if (!tanggalKembali.value.trim()) {
                tanggalKembali.classList.add('is-invalid');
                tanggalKembali.insertAdjacentHTML('afterend', '<div class="invalid-feedback d-block">*kolom wajib diisi</div>');
                valid = false;
            }
            // Pengikut/Pendamping (WAJIB)
            const pengikut = form.querySelectorAll('[name="pengikut[]"]');
            let pengikutValid = false;
            pengikut.forEach(el => {
                if (el.value.trim()) pengikutValid = true;
            });
            if (!pengikutValid) {
                pengikut.forEach(el => {
                    el.classList.add('is-invalid');
                    el.insertAdjacentHTML('afterend', '<div class="invalid-feedback d-block">*kolom wajib diisi</div>');
                });
                valid = false;
            }
            // Pembebanan Anggaran: Instansi & Akun
            const instansi = form.querySelector('[name="instansi"]');
            const akun = form.querySelector('[name="akun"]');
            if (!instansi.value.trim()) {
                instansi.classList.add('is-invalid');
                instansi.insertAdjacentHTML('afterend', '<div class="invalid-feedback d-block">*kolom wajib diisi</div>');
                valid = false;
            }
            if (!akun.value.trim()) {
                akun.classList.add('is-invalid');
                akun.insertAdjacentHTML('afterend', '<div class="invalid-feedback d-block">*kolom wajib diisi</div>');
                valid = false;
            }
            if (!valid) {
                e.preventDefault();
                // Scroll dan fokus ke field error pertama
                const firstInvalid = form.querySelector('.is-invalid');
                if (firstInvalid) {
                    firstInvalid.scrollIntoView({behavior: 'smooth', block: 'center'});
                    firstInvalid.focus();
                }
            }
        });
    });
</script>
@endpush

@push('styles')
<style>
@media (max-width: 576px) {
    .form-label, .form-control, .btn, .btn-sm { font-size: 13px; }
    .card { margin-bottom: 1rem; }
    .container, .row, .col-md-8 { padding: 0 4px !important; }
    .input-group .btn { padding: 6px 10px; }
    .input-group, .row.mb-2 { flex-direction: column; }
    .input-group > .form-control, .row.mb-2 > div { width: 100% !important; margin-bottom: 6px; }
    .d-flex.justify-content-between { flex-direction: column; gap: 8px; }
}
</style>
@endpush 