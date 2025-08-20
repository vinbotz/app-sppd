@extends('layouts.app')

@section('content')
<script>window.disablePageLoader = true;</script>
<style>
/* Nonaktifkan loading animation khusus di halaman supervisor dashboard */
.page-loader {
    display: none !important;
    opacity: 0 !important;
    visibility: hidden !important;
}
</style>
<div class="page-content">
    <div class="container">
        <h2 class="mb-4 fw-bold">Dashboard Supervisor</h2>
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-white bg-primary h-100">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <i class="fas fa-file-alt fa-2x mb-2"></i>
                        <div class="fs-6">Pengajuan SPPD</div>
                        <div class="fs-3 fw-bold">{{ $total }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-white bg-success h-100">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <i class="fas fa-check-circle fa-2x mb-2"></i>
                        <div class="fs-6">Disetujui</div>
                        <div class="fs-3 fw-bold">{{ $disetujui }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-white bg-danger h-100">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <i class="fas fa-times-circle fa-2x mb-2"></i>
                        <div class="fs-6">Ditolak</div>
                        <div class="fs-3 fw-bold">{{ $ditolak }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-dark bg-warning h-100">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <i class="fas fa-hourglass-half fa-2x mb-2"></i>
                        <div class="fs-6">Belum Selesai</div>
                        <div class="fs-3 fw-bold">{{ $belumSelesai }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0 fw-semibold">Riwayat Pengajuan Terbaru</h4>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle shadow-sm">
                <thead class="table-primary">
                    <tr class="text-center align-middle">
                        <th>No</th>
                        <th>Nomor SPPD</th>
                        <th>Kegiatan</th>
                        <th>Tempat Berangkat</th>
                        <th>Tujuan</th>
                        <th>Tanggal Berangkat</th>
                        <th>Tanggal Pulang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sppds->sortByDesc('created_at') as $i => $sppd)
                    <tr>
                        <td class="text-center">{{ $i+1 }}</td>
                        <td>{{ $sppd->nomor_sppd ?? '-' }}</td>
                        <td>{{ $sppd->kegiatan ?? '-' }}</td>
                        <td>{{ $sppd->tempat_berangkat ?? '-' }}</td>
                        <td>
                            @if(is_array($sppd->tempat_tujuan))
                                {{ implode(', ', $sppd->tempat_tujuan) }}
                            @else
                                {{ $sppd->tempat_tujuan ?? '-' }}
                            @endif
                        </td>
                        <td class="text-center">{{ $sppd->tanggal_berangkat ? $sppd->tanggal_berangkat->format('d-m-Y') : '-' }}</td>
                        <td class="text-center">{{ $sppd->tanggal_kembali ? $sppd->tanggal_kembali->format('d-m-Y') : '-' }}</td>
                        <td class="text-center">
                            @if($sppd->status == 'disetujui')
                                <span class="badge bg-success px-3 py-2">Disetujui</span>
                            @elseif($sppd->status == 'ditolak')
                                <span class="badge bg-danger px-3 py-2">Ditolak</span>
                            @else
                                <span class="badge bg-warning text-dark px-3 py-2">Belum Selesai</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('supervisor.sppd.show', $sppd->id) }}?from_dashboard=1" class="btn btn-sm btn-info" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Belum ada pengajuan SPPD.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@if(session('login_success'))
<div id="toastLogin" class="position-fixed top-0 end-0 p-3" style="z-index: 9999; right: 1rem; top: 1rem;">
    <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body fw-bold">
                <i class="fas fa-check-circle me-2"></i>{{ session('login_success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
<script>
    setTimeout(function() {
        document.getElementById('toastLogin').style.display = 'none';
    }, 2500);
    document.querySelectorAll('.nav-link, .navbar-brand, .dropdown-item').forEach(function(el) {
        el.addEventListener('click', function() {
            var toast = document.getElementById('toastLogin');
            if(toast) toast.style.display = 'none';
        });
    });
</script>
@endif
@endsection
