@extends('layouts.app')

@section('content')
<script>
// Set menu aktif untuk halaman detail SPPD
document.addEventListener('DOMContentLoaded', function() {
    function setActiveMenu() {
        // Bersihkan class aktif dari semua menu
        var allMenuLinks = document.querySelectorAll('.nav-link');
        allMenuLinks.forEach(function(link) { link.classList.remove('active-menu'); });

        // Deteksi apakah halaman dibuka dari dashboard
        var params = new URLSearchParams(window.location.search);
        var fromDashboard = params.get('from_dashboard') === '1';

        var dashboardLink = document.querySelector('a[href*="supervisor/dashboard"]');
        var daftarPengajuanLink = document.querySelector('a[href*="pengajuan"]');

        if (fromDashboard) {
            // Jika dari dashboard, tandai Dashboard sebagai aktif
            if (dashboardLink) dashboardLink.classList.add('active-menu');
        } else {
            // Selain itu, tandai Daftar Pengajuan sebagai aktif
            if (daftarPengajuanLink) daftarPengajuanLink.classList.add('active-menu');
        }
    }

    setActiveMenu();
});
</script>
<script>window.disablePageLoader = true;</script>
<style>
/* Nonaktifkan loading animation khusus di halaman supervisor show */
.page-loader {
    display: none !important;
    opacity: 0 !important;
    visibility: hidden !important;
}

/* Perbaikan tampilan untuk detail SPPD */
.card {
    border: none;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.badge {
    font-weight: 500;
    letter-spacing: 0.5px;
}

.text-muted.small.fw-bold {
    color: #6c757d !important;
    font-size: 0.875rem;
    font-weight: 600 !important;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.fs-5 {
    color: #2c3e50;
    font-weight: 500;
}

.fs-6 {
    color: #34495e;
}

/* Perbaikan tampilan modal */
.modal-header {
    border-bottom: none;
}

.modal-footer {
    border-top: none;
    padding: 1rem 1.5rem 1.5rem;
}

.alert {
    border: none;
    border-radius: 0.5rem;
}

/* Perbaikan tampilan form */
.form-control, .form-select {
    border-radius: 0.5rem;
    border: 1px solid #dee2e6;
    transition: all 0.2s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

/* Perbaikan tampilan tombol */
.btn {
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.15);
}

/* Perbaikan tampilan list */
ul {
    list-style-type: none;
    padding-left: 0;
}

ul li {
    padding: 0.25rem 0;
    border-bottom: 1px solid #f8f9fa;
}

ul li:last-child {
    border-bottom: none;
}

/* Perbaikan tampilan informasi approval */
.approval-info {
    background: #f8f9fa;
    border-radius: 0.5rem;
    padding: 1rem;
    margin-top: 1rem;
}

/* Memastikan menu aktif terlihat jelas di halaman detail SPPD */
.nav-link.active-menu {
    background-color: #ffffff !important;
    color: #667eea !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15) !important;
    font-weight: 600 !important;
    position: relative !important;
    z-index: 10 !important;
}

.nav-link.active-menu::after {
    content: '' !important;
    position: absolute !important;
    bottom: -2px !important;
    left: 50% !important;
    transform: translateX(-50%) !important;
    width: 80% !important;
    height: 2px !important;
    background-color: #667eea !important;
    border-radius: 1px !important;
    z-index: 11 !important;
}

.nav-link.active-menu i {
    color: #667eea !important;
}

/* Override untuk memastikan menu Dashboard tidak aktif */
.nav-link:not(.active-menu) {
    background-color: transparent !important;
    color: #e3f2fd !important;
}

.nav-link:not(.active-menu) i {
    color: #e3f2fd !important;
}

/* Perbaikan modal backdrop - Solusi yang lebih robust */
.modal-backdrop {
    z-index: 1040 !important;
    transition: opacity 0.15s linear !important;
}

.modal {
    z-index: 1050 !important;
}

/* Pastikan backdrop tidak tertinggal saat modal tidak aktif */
body:not(.modal-open) .modal-backdrop,
.modal-backdrop:not(.show) {
    display: none !important;
    opacity: 0 !important;
    pointer-events: none !important;
}

/* Hapus backdrop yang mungkin tertinggal dari CSS lain */
[style*="background: rgba(0, 0, 0, 0.5)"][style*="position: fixed"]:not(.modal-backdrop.show) {
    display: none !important;
    opacity: 0 !important;
    pointer-events: none !important;
}

/* Perbaikan untuk body yang tidak bisa di-scroll */
body.modal-open {
    overflow: auto !important;
    padding-right: 0 !important;
}

/* Pastikan backdrop hanya muncul saat modal aktif */
.modal-backdrop.show {
    opacity: 0.5 !important;
    pointer-events: auto !important;
}

/* Hapus backdrop yang mungkin tertinggal dari Bootstrap */
.modal-backdrop.fade:not(.show) {
    opacity: 0 !important;
    pointer-events: none !important;
}

/* Perbaikan untuk modal yang tidak tertutup dengan benar */
.modal-backdrop.fade.show {
    opacity: 0.5 !important;
    transition: opacity 0.15s linear !important;
}

/* Styling untuk notification popup */
.notification-popup {
    animation: popupFadeIn 0.3s ease-out;
}

@keyframes popupFadeIn {
    from {
        opacity: 0;
        transform: translate(-50%, -50%) scale(0.8);
    }
    to {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
    }
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 rounded-4 mt-4 p-2">
                <div class="card-header bg-primary bg-gradient text-white rounded-4 d-flex justify-content-between align-items-center border-0" style="min-height:60px;">
                    <h4 class="mb-0 fw-bold"><i class="fas fa-file-alt me-2"></i>Detail SPPD</h4>
                    @php
                        $fromDashboard = request()->query('from_dashboard') == '1';
                    @endphp
                    <a href="{{ $fromDashboard ? route('supervisor.dashboard') : route('supervisor.pengajuan.index') }}" class="btn btn-light btn-sm px-3"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-6">
                    <div class="mb-2">
                                <span class="text-muted small fw-bold">Nomor SPPD</span>
                                <div class="fs-5 fw-bold text-primary">{{ $sppd->nomor_sppd ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <span class="text-muted small fw-bold">Diajukan pada</span>
                                <div class="fs-5 fw-bold">@wibTime($sppd->created_at)</div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mb-2">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <div class="text-muted small fw-bold">Pengguna Anggaran</div>
                                <div class="fs-5">{{ $sppd->pengguna_anggaran ?? '-' }}</div>
                            </div>
                            <div class="mb-2">
                                <div class="text-muted small fw-bold">Nama/NIP/Pangkat Golongan</div>
                                <div>
                                    @if(is_array($sppd->nama_pegawai))
                                        <ul class="mb-0 ps-3 small">
                                        @foreach($sppd->nama_pegawai as $i => $nama)
                                            <li class="fs-6">
                                                <strong>{{ $nama }}</strong><br>
                                                <span class="text-muted">NIP: {{ $sppd->nip_pegawai[$i] ?? '-' }}</span><br>
                                                <span class="text-muted">Pangkat: {{ $sppd->pangkat_golongan[$i] ?? '-' }}</span>
                                            </li>
                                        @endforeach
                                        </ul>
                                    @else
                                        <span class="fs-6">{{ $sppd->nama_pegawai ?? '-' }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="text-muted small fw-bold">Kegiatan</div>
                                <div class="fs-5">{{ $sppd->kegiatan ?? '-' }}</div>
                            </div>
                            <div class="mb-2">
                                <div class="text-muted small fw-bold">Alat Angkut</div>
                                <div class="fs-5">{{ $sppd->alat_angkut ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <div class="text-muted small fw-bold">Tempat Berangkat</div>
                                <div class="fs-5">{{ $sppd->tempat_berangkat ?? '-' }}</div>
                            </div>
                            <div class="mb-2">
                                <div class="text-muted small fw-bold">Tempat Tujuan</div>
                                <div>
                                    @if(is_array($sppd->tempat_tujuan) && count($sppd->tempat_tujuan) > 0)
                                        <ul class="mb-0 ps-3 small">
                                        @foreach($sppd->tempat_tujuan as $tujuan)
                                            @if($tujuan)
                                            <li class="fs-6">{{ $tujuan }}</li>
                                            @endif
                                        @endforeach
                                        </ul>
                                    @else
                                        <span class="fs-6">{{ $sppd->tempat_tujuan ?? '-' }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="text-muted small fw-bold">Lama Perjalanan</div>
                                <div class="fs-5">{{ $sppd->lama_perjalanan ?? '-' }}</div>
                            </div>
                            <div class="mb-2">
                                <div class="text-muted small fw-bold">Tanggal Berangkat</div>
                                <div class="fs-5">{{ $sppd->tanggal_berangkat ? \Carbon\Carbon::parse($sppd->tanggal_berangkat)->format('d-m-Y') : '-' }}</div>
                            </div>
                            <div class="mb-2">
                                <div class="text-muted small fw-bold">Tanggal Pulang</div>
                                <div class="fs-5">{{ $sppd->tanggal_kembali ? \Carbon\Carbon::parse($sppd->tanggal_kembali)->format('d-m-Y') : '-' }}</div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-3">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="mb-2">
                                <div class="text-muted small fw-bold">Diajukan oleh</div>
                                <div class="fs-6">
                                    <i class="fas fa-user me-1"></i>
                                    {{ $sppd->user->name ?? 'Admin' }}
                                    <span class="text-muted">({{ $sppd->user->email ?? '-' }})</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mb-2">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <div class="text-muted small fw-bold">Pengikut/Pendamping</div>
                                <div>
                                    @if(is_array($sppd->pengikut) && count($sppd->pengikut) > 0)
                                        <ul class="mb-0 ps-3 small">
                                        @foreach($sppd->pengikut as $i => $p)
                                            @if($p)
                                            <li class="fs-6">
                                                    <strong>{{ $p }}</strong>
                                                @if(isset($sppd->tanggal_lahir_pengikut[$i]) && $sppd->tanggal_lahir_pengikut[$i])
                                                        <br><span class="text-muted">Tanggal Lahir: {{ \Carbon\Carbon::parse($sppd->tanggal_lahir_pengikut[$i])->format('d-m-Y') }}</span>
                                                @endif
                                            </li>
                                            @endif
                                        @endforeach
                                        </ul>
                                    @else
                                        <span class="fs-6 text-muted">Tidak ada pengikut</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="text-muted small fw-bold">Pembebanan Anggaran</div>
                                <div class="fs-6">
                                    <div class="mb-1">
                                        <span class="fw-semibold text-primary">Instansi:</span><br>
                                        <span class="badge bg-light text-dark border">{{ $sppd->instansi ?? '-' }}</span>
                                    </div>
                                    <div>
                                        <span class="fw-semibold text-primary">Akun:</span><br>
                                        <span class="badge bg-info text-dark">{{ $sppd->akun ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <div class="text-muted small fw-bold">Keterangan</div>
                                <div class="fs-5">{{ $sppd->keterangan ?? '-' }}</div>
                            </div>
                            @if($sppd->status == 'ditolak' && $sppd->catatan)
                            <div class="mb-2">
                                    <div class="text-muted small fw-bold text-danger">Catatan Penolakan</div>
                                    <div class="fs-5 text-danger">{{ $sppd->catatan }}</div>
                                </div>
                            @endif
                            <div class="mb-2">
                                <div class="text-muted small fw-bold">Status SPPD</div>
                                <div class="fs-5">
                                    @if($sppd->status == 'disetujui')
                                        <span class="badge px-4 py-2 fs-6" style="background:linear-gradient(90deg,#43e97b,#38f9d7);color:#fff;">
                                            <i class="fas fa-check-circle me-1"></i> Disetujui
                                    </span>
                                    @elseif($sppd->status == 'ditolak')
                                        <span class="badge px-4 py-2 fs-6" style="background:linear-gradient(90deg,#ff5858,#f09819);color:#fff;">
                                            <i class="fas fa-times-circle me-1"></i> Ditolak
                                        </span>
                                    @else
                                        <span class="badge px-4 py-2 fs-6" style="background:linear-gradient(90deg,#fbc02d,#ffe082);color:#333;">
                                            <i class="fas fa-hourglass-half me-1"></i> Menunggu Persetujuan
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @if($sppd->approved_at)
                                <div class="mb-2">
                                    <div class="text-muted small fw-bold">
                                        @if($sppd->status == 'disetujui')
                                            <i class="fas fa-check-circle text-success me-1"></i>Disetujui pada
                                        @elseif($sppd->status == 'ditolak')
                                            <i class="fas fa-times-circle text-danger me-1"></i>Ditolak pada
                                        @endif
                                    </div>
                                    <div class="fs-6 text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ \Carbon\Carbon::parse($sppd->approved_at)->format('d-m-Y H:i') }}
                                        @if($sppd->approved_by)
                                            <br><i class="fas fa-user me-1"></i>
                                            oleh {{ \App\Models\User::find($sppd->approved_by)->name ?? 'Supervisor' }}
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @php
                        $fromDashboard = request()->query('from_dashboard') == '1';
                    @endphp
                    @if(!$fromDashboard)
                        <hr class="my-4">
                        @if($sppd->status == 'diajukan')
                            <div class="d-flex gap-2 justify-content-end">
                                <form action="{{ route('supervisor.sppd.approve', $sppd->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success px-4 py-2">
                                        <i class="fas fa-check me-1"></i> Setujui SPPD
                                    </button>
                                </form>
                                <button type="button" class="btn btn-danger px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalTolak{{$sppd->id}}">
                                    <i class="fas fa-times me-1"></i> Tolak SPPD
                                </button>
                            </div>
                        @elseif($sppd->status == 'disetujui' || $sppd->status == 'ditolak')
                            <div class="d-flex gap-2 justify-content-end">
                                <button type="button" class="btn btn-warning px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalEditStatus">
                                    <i class="fas fa-edit me-1"></i> Edit Status
                                </button>
                            </div>
                        @endif
                    @endif

                    <!-- Modal Tolak -->
                    <div class="modal fade" id="modalTolak{{$sppd->id}}" tabindex="-1" aria-labelledby="modalTolakLabel{{$sppd->id}}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title" id="modalTolakLabel{{$sppd->id}}">
                                        <i class="fas fa-times-circle me-2"></i>Tolak SPPD
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('supervisor.sppd.reject', $sppd->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <strong>Perhatian:</strong> SPPD akan ditolak dan tidak dapat diproses lebih lanjut.
                                        </div>
                                        <div class="mb-3">
                                            <label for="catatan" class="form-label fw-bold">Catatan/Alasan Penolakan <span class="text-danger">*</span></label>
                                            <textarea name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="4" placeholder="Masukkan alasan penolakan SPPD..." required>{{ old('catatan') }}</textarea>
                                            @error('catatan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times me-1"></i> Batal
                                        </button>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-times me-1"></i> Tolak SPPD
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Edit Status -->
                    <div class="modal fade" id="modalEditStatus" tabindex="-1" aria-labelledby="modalEditStatusLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-dark">
                                    <h5 class="modal-title" id="modalEditStatusLabel">
                                        <i class="fas fa-edit me-2"></i>Edit Status SPPD
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('supervisor.sppd.updateApproval', $sppd->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <strong>Info:</strong> Anda dapat mengubah status SPPD yang sudah ada.
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label fw-bold">Status SPPD <span class="text-danger">*</span></label>
                                            <select name="status" id="statusEdit" class="form-select" required>
                                                <option value="disetujui" @if($sppd->status=='disetujui') selected @endif>Disetujui</option>
                                                <option value="ditolak" @if($sppd->status=='ditolak') selected @endif>Ditolak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3" id="catatanEditGroup" style="display: {{ $sppd->status=='ditolak' ? 'block' : 'none' }};">
                                            <label for="catatan_edit" class="form-label fw-bold">Catatan/Alasan <span class="text-danger">*</span></label>
                                            <textarea name="catatan" id="catatan_edit" class="form-control" rows="4" placeholder="Masukkan catatan atau alasan...">{{ $sppd->catatan }}</textarea>
                                            <small id="catatanEditError" class="text-danger" style="display:none;">
                                                <i class="fas fa-exclamation-circle me-1"></i>Catatan harus diisi untuk status ditolak
                                            </small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times me-1"></i> Batal
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var statusEdit = document.getElementById('statusEdit');
    var catatanGroup = document.getElementById('catatanEditGroup');
    var catatanEdit = document.getElementById('catatan_edit');
    var formEditStatus = document.querySelector('#modalEditStatus form');
    var catatanEditError = document.getElementById('catatanEditError');

    // Fungsi untuk membersihkan modal backdrop
    function cleanupModalBackdrop() {
        // Hapus backdrop yang mungkin tertinggal
        var backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(function(backdrop) {
            backdrop.remove();
        });
        
        // Hapus class modal-open dari body
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        
        // Hapus backdrop yang mungkin dibuat oleh CSS
        var customBackdrops = document.querySelectorAll('[style*="background: rgba(0, 0, 0, 0.5)"]');
        customBackdrops.forEach(function(backdrop) {
            if (backdrop.classList.contains('modal-backdrop') || backdrop.style.position === 'fixed') {
                backdrop.remove();
            }
        });
    }

    // Event listener untuk modal yang ditutup
    var modals = document.querySelectorAll('.modal');
    modals.forEach(function(modal) {
        modal.addEventListener('hidden.bs.modal', function() {
            cleanupModalBackdrop();
            autoCleanup();
        });
        
        modal.addEventListener('hide.bs.modal', function() {
            cleanupModalBackdrop();
            autoCleanup();
        });
        
        modal.addEventListener('shown.bs.modal', function() {
            // Pastikan hanya ada satu backdrop saat modal terbuka
            var backdrops = document.querySelectorAll('.modal-backdrop');
            if (backdrops.length > 1) {
                for (var i = 1; i < backdrops.length; i++) {
                    backdrops[i].remove();
                }
            }
        });
    });

    // Event listener untuk tombol close modal
    var closeButtons = document.querySelectorAll('[data-bs-dismiss="modal"]');
    closeButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            setTimeout(function() {
                cleanupModalBackdrop();
                autoCleanup();
            }, 100);
        });
    });
    
    // Event listener untuk form submit yang menutup modal
    var forms = document.querySelectorAll('form');
    forms.forEach(function(form) {
        form.addEventListener('submit', function() {
            setTimeout(function() {
                cleanupModalBackdrop();
                autoCleanup();
            }, 200);
        });
    });

    function toggleCatatan() {
        if (statusEdit.value === 'ditolak') {
            catatanGroup.style.display = 'block';
            catatanEdit.setAttribute('required', 'required');
        } else {
            catatanGroup.style.display = 'none';
            catatanEdit.removeAttribute('required');
            catatanEdit.value = '';
            if (catatanEditError) catatanEditError.style.display = 'none';
        }
    }

    if (statusEdit) {
    statusEdit.addEventListener('change', toggleCatatan);
    toggleCatatan();
    }

    if(formEditStatus) {
        formEditStatus.addEventListener('submit', function(e) {
            if(statusEdit.value === 'ditolak' && catatanEdit.value.trim() === '') {
                if (catatanEditError) catatanEditError.style.display = 'block';
                catatanEdit.focus();
                e.preventDefault();
                return false;
            } else {
                if (catatanEditError) catatanEditError.style.display = 'none';
            }
        });
    }

    // Tambahkan validasi real-time untuk textarea catatan
    if (catatanEdit) {
        catatanEdit.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                if (catatanEditError) catatanEditError.style.display = 'none';
            }
        });
    }

    // Cleanup otomatis yang lebih robust
    function autoCleanup() {
        // Hapus semua backdrop yang mungkin tertinggal
        var allBackdrops = document.querySelectorAll('.modal-backdrop, [style*="background: rgba(0, 0, 0, 0.5)"]');
        allBackdrops.forEach(function(backdrop) {
            if (backdrop && backdrop.parentNode) {
                backdrop.remove();
            }
        });
        
        // Reset body state
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        
        // Hapus backdrop yang mungkin dibuat oleh Bootstrap
        var bootstrapBackdrops = document.querySelectorAll('[class*="backdrop"]');
        bootstrapBackdrops.forEach(function(backdrop) {
            if (backdrop && backdrop.style.position === 'fixed' && 
                (backdrop.style.background.includes('rgba(0, 0, 0') || backdrop.style.backgroundColor.includes('rgba(0, 0, 0'))) {
                backdrop.remove();
            }
        });
        
        // Hapus backdrop yang mungkin tertinggal dari CSS
        var fixedElements = document.querySelectorAll('[style*="position: fixed"][style*="background"]');
        fixedElements.forEach(function(element) {
            if (element && (element.style.background.includes('rgba(0, 0, 0, 0.5)') || 
                           element.style.backgroundColor.includes('rgba(0, 0, 0, 0.5)'))) {
                if (!element.classList.contains('modal') && !element.classList.contains('notification-popup')) {
                    element.remove();
                }
            }
        });
        
        // Hapus semua elemen dengan background hitam transparan yang mungkin tertinggal
        var allFixedElements = document.querySelectorAll('*');
        allFixedElements.forEach(function(element) {
            if (element && element.style && element.style.position === 'fixed' && 
                (element.style.background === 'rgba(0, 0, 0, 0.5)' || 
                 element.style.backgroundColor === 'rgba(0, 0, 0, 0.5)' ||
                 element.style.background === 'rgba(0, 0, 0, 0.5) none repeat scroll 0% 0%' ||
                 element.style.backgroundColor === 'rgba(0, 0, 0, 0.5) none repeat scroll 0% 0%')) {
                if (!element.classList.contains('modal') && 
                    !element.classList.contains('notification-popup') && 
                    !element.classList.contains('alert')) {
                    element.remove();
                }
            }
        });
        
        // Hapus semua elemen dengan z-index tinggi yang mungkin backdrop
        var highZIndexElements = document.querySelectorAll('[style*="z-index: 1040"], [style*="z-index: 1050"], [style*="z-index: 1060"]');
        highZIndexElements.forEach(function(element) {
            if (element && element.style.position === 'fixed' && 
                (element.style.background.includes('rgba(0, 0, 0') || element.style.backgroundColor.includes('rgba(0, 0, 0'))) {
                if (!element.classList.contains('modal') && 
                    !element.classList.contains('notification-popup') && 
                    !element.classList.contains('alert')) {
                    element.remove();
                }
            }
        });
        
        // Hapus semua elemen dengan class yang mungkin backdrop
        var backdropClasses = document.querySelectorAll('.modal-backdrop, .backdrop, [class*="backdrop"]');
        backdropClasses.forEach(function(element) {
            if (element && element.style.position === 'fixed') {
                element.remove();
            }
        });
    }
    
    // Cleanup saat halaman dimuat (sekali saja)
    autoCleanup();
    
    // Cleanup saat user melakukan click di luar modal
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.modal')) {
            autoCleanup();
        }
    }, true);
    
    // Cleanup saat modal Bootstrap tersembunyi
    document.addEventListener('hidden.bs.modal', autoCleanup);
    document.addEventListener('hide.bs.modal', autoCleanup);
    
    // Tambahkan event listener untuk semua modal yang ada
    var allModals = document.querySelectorAll('.modal');
    allModals.forEach(function(modal) {
        modal.addEventListener('hidden.bs.modal', autoCleanup);
        modal.addEventListener('hide.bs.modal', autoCleanup);
    });
    
    // Cleanup tambahan setiap 500ms untuk memastikan tidak ada backdrop yang tertinggal
    setInterval(autoCleanup, 500);
});
</script>
@if(session('success') || session('edited_supervisor') || session('status_supervisor') || session('error') || session('approved_sppd') || session('rejected_sppd'))
    <!-- Modal Success (Animasi Pop Up) -->
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
                    <h4 class="mt-3 text-success fw-bold">
                        @if(session('rejected_sppd'))
                            SPPD berhasil ditolak
                        @elseif(session('approved_sppd'))
                            SPPD berhasil disetujui
                        @elseif(session('status_supervisor'))
                            Status SPPD berhasil diperbarui
                        @elseif(session('error') || (isset($sppd) && $sppd->status == 'ditolak'))
                            SPPD berhasil ditolak
                        @else
                            SPPD berhasil disetujui
                        @endif
                    </h4>
                    <div class="text-muted">{{ session('rejected_sppd') ?: session('approved_sppd') ?: session('error') ?: session('success') ?: session('status_supervisor') ?: session('edited_supervisor') }}</div>
                </div>
            </div>
        </div>
    </div>
    <script>
        setTimeout(function() {
            document.getElementById('successModal').style.display = 'none';
        }, 2000);
    </script>
@endif



@if(session('created_sppd'))
    <!-- Modal Success untuk pembuatan SPPD -->
    <div class="modal fade show" id="creationModal" tabindex="-1" aria-modal="true" role="dialog" style="display:block; background:rgba(0,0,0,0.3);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4 border-0" style="background:transparent;box-shadow:none;">
                <div class="bg-white rounded-4 p-4 shadow-lg d-flex flex-column align-items-center">
                    <svg width="90" height="90" viewBox="0 0 80 80">
                        <circle cx="40" cy="40" r="38" fill="#e6f9ed" stroke="#34c759" stroke-width="4"/>
                        <polyline points="25,43 37,55 57,30" fill="none" stroke="#34c759" stroke-width="6" stroke-linecap="round" stroke-linejoin="round">
                            <animate attributeName="points" dur="0.5s" to="25,43 37,55 57,30" fill="freeze" />
                        </polyline>
                    </svg>
                    <h4 class="mt-3 text-success fw-bold">Congratulations!</h4>
                    <div class="text-muted">SPPD berhasil diajukan dan menunggu persetujuan.</div>
                    <button class="btn btn-primary mt-3 px-4 py-2" onclick="closeCreationModal()" style="border-radius: 0.75rem; background: linear-gradient(135deg, #3b82f6, #1d4ed8); border: none;">
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function closeCreationModal() {
            document.getElementById('creationModal').style.display = 'none';
        }
        
        // Auto-hide setelah 5 detik jika user tidak klik OK
        setTimeout(function() {
            var modal = document.getElementById('creationModal');
            if(modal && modal.style.display !== 'none') {
                closeCreationModal();
            }
        }, 5000);
    </script>
@endif
@endsection 