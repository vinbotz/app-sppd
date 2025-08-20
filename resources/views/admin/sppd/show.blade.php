@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="success-notification-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); display: flex; align-items: center; justify-content: center; z-index: 9999;">
        <div class="success-modal-content" style="background: white; border-radius: 1rem; padding: 2rem; text-align: center; max-width: 400px; margin: 0 1rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
            <div class="success-circle mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #22c55e, #16a34a); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-check text-white" style="font-size: 2rem;"></i>
            </div>
            <h3 class="text-success fw-bold mb-2" style="font-size: 1.5rem;">SPPD Berhasil Disetujui</h3>
            <p class="text-muted mb-0">{{ session('success') }}</p>
        </div>
    </div>
    <script>
        setTimeout(function() {
            var notif = document.querySelector('.success-notification-overlay');
            if (notif) {
                notif.style.opacity = '0';
                notif.style.transition = 'opacity 0.3s ease';
                setTimeout(function() { notif.remove(); }, 300);
            }
        }, 2000);
    </script>
@endif
<style>
/* Fix modal blur effect - COMPLETE SOLUTION */
.modal {
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
}

.modal-backdrop {
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
}

.modal-content {
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
    background: #fff !important;
}

/* Ensure modal is above all other elements */
.modal.show {
    z-index: 1055 !important;
}

.modal-backdrop.show {
    z-index: 1050 !important;
}

/* Remove ALL blur effects from EVERY element */
* {
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
}

/* Specific elements that commonly cause blur issues */
body, html, .container, .row, .col-md-10, .card, .card-body, .card-header,
.btn, .form-control, .form-select, .navbar, .dropdown-menu {
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
}

/* Force remove blur when modal is open */
body.modal-open {
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
}

/* Ensure no blur on any Bootstrap components */
.bootstrap, .bootstrap * {
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 rounded-4 mt-4 p-2">
                <div class="card-header bg-primary bg-gradient text-white rounded-4 d-flex justify-content-between align-items-center border-0" style="min-height:60px;">
                    <h4 class="mb-0 fw-bold"><i class="fas fa-file-alt me-2"></i>Detail SPPD</h4>
                    <a href="{{ url()->previous() }}" class="btn btn-light btn-sm px-3"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
                </div>
                <div class="card-body p-4">
                    <div class="mb-2">
                        <span class="text-muted small fw-bold">Diajukan</span>
                        <div class="fs-5 fw-bold mb-2">@wibTime($sppd->created_at)</div>
                    </div>
                    <div class="row g-3 mb-2">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <div class="text-muted small fw-bold">Pengguna Anggaran</div>
                                <div class="fs-5">{{ $sppd->pengguna_anggaran ?? '-' }}</div>
                            </div>
                            <div class="mb-2">
                                <div class="text-muted small fw-bold">Nama/NIP/Jabatan</div>
                                <div>
                                    @if(is_array($sppd->nama_pegawai))
                                        <ul class="mb-0 ps-3 small">
                                        @foreach($sppd->nama_pegawai as $i => $nama)
                                            <li class="fs-6">
                                                {{ $nama }} / {{ $sppd->nip_pegawai[$i] ?? '' }} / {{ $sppd->jabatan_pegawai[$i] ?? '' }}
                                                
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
                                    @if(is_array($sppd->tempat_tujuan))
                                        <ul class="mb-0 ps-3 small">
                                        @foreach($sppd->tempat_tujuan as $tujuan)
                                            <li class="fs-6">{{ $tujuan }}</li>
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
                    <div class="row g-3 mb-2">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <div class="text-muted small fw-bold">Pengikut/Pendamping</div>
                                <div>
                                    @if(is_array($sppd->pengikut))
                                        <ul class="mb-0 ps-3 small">
                                        @foreach($sppd->pengikut as $i => $p)
                                            <li class="fs-6">
                                                {{ $p }}
                                                @if(isset($sppd->tanggal_lahir_pengikut[$i]) && $sppd->tanggal_lahir_pengikut[$i])
                                                    <span class="text-muted">({{ \Carbon\Carbon::parse($sppd->tanggal_lahir_pengikut[$i])->format('d-m-Y') }})</span>
                                                @endif
                                            </li>
                                        @endforeach
                                        </ul>
                                    @else
                                        <span class="fs-6">{{ $sppd->pengikut ?? '-' }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="text-muted small fw-bold">Pembebanan Anggaran</div>
                                <div class="fs-5">
                                    <span class="fw-semibold text-primary">Instansi:</span> <span class="badge bg-light text-dark border">{{ $sppd->instansi ?? '-' }}</span><br>
                                    <span class="fw-semibold text-primary">Akun:</span> <span class="badge bg-info text-dark">{{ $sppd->akun ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <div class="text-muted small fw-bold">Keterangan</div>
                                <div class="fs-5">{{ $sppd->keterangan ?? '-' }}</div>
                            </div>
                            <div class="mb-2">
                                <div class="text-muted small fw-bold">Status</div>
                                <div class="fs-5 position-relative d-inline-block">
                                    <span class="badge px-4 py-2 fs-6"
                                        @if($sppd->status == 'disetujui') style="background:linear-gradient(90deg,#43e97b,#38f9d7);color:#fff;" @endif
                                        @if($sppd->status == 'ditolak') style="background:linear-gradient(90deg,#ff5858,#f09819);color:#fff;" @endif
                                        @if($sppd->status != 'disetujui' && $sppd->status != 'ditolak') style="background:linear-gradient(90deg,#fbc02d,#ffe082);color:#333;" @endif
                                    >
                                        @if($sppd->status == 'disetujui') <i class="fas fa-check-circle me-1"></i> @endif
                                        @if($sppd->status == 'ditolak') <i class="fas fa-times-circle me-1"></i> @endif
                                        @if($sppd->status != 'disetujui' && $sppd->status != 'ditolak') <i class="fas fa-hourglass-half me-1"></i> @endif
                                        {{ ucfirst($sppd->status) == 'Diajukan' ? 'Belum Selesai' : ucfirst($sppd->status) }}
                                    </span>
                                    @if($sppd->status == 'ditolak' && !empty($sppd->catatan))
                                        <span id="alasanInfoBtn" tabindex="0" style="cursor:pointer;display:inline-block;margin-left:7px;vertical-align:middle;">
                                            <i class="fas fa-info-circle" style="font-size:1.1rem;color:#ff5858;"></i>
                                        </span>
                                        <div id="alasanPopover" class="shadow-sm" style="display:none;position:absolute;z-index:10;left:110%;top:50%;transform:translateY(-50%);background:#fff0f1;color:#b91c1c;border-radius:0.5rem;padding:8px 14px;font-size:0.97rem;min-width:120px;max-width:220px;box-shadow:0 2px 8px 0 #ffbdbd33;">
                                            <div class="d-flex align-items-center mb-1" style="gap:5px;">
                                                <i class="fas fa-info-circle" style="font-size:1rem;"></i>
                                                <span class="fw-semibold" style="font-size:0.97rem;">Alasan:</span>
                                            </div>
                                            <div class="fst-italic" style="font-size:0.97rem;">{{ $sppd->catatan }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($sppd->status == 'diajukan' && auth()->user()->role == 'supervisor')
                        <div class="mt-4 d-flex gap-2 justify-content-end">
                            <form action="{{ route('admin.sppd.approve', $sppd->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success px-4"><i class="fas fa-check me-1"></i> Setujui</button>
                            </form>
                            <form action="{{ route('admin.sppd.reject', $sppd->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger px-4"><i class="fas fa-times me-1"></i> Tolak</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var infoBtn = document.getElementById('alasanInfoBtn');
    var popover = document.getElementById('alasanPopover');
    if(infoBtn && popover) {
        infoBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            popover.style.display = popover.style.display === 'block' ? 'none' : 'block';
        });
        document.addEventListener('click', function(e) {
            if(popover.style.display === 'block') popover.style.display = 'none';
        });
        popover.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});
</script>
@endpush 