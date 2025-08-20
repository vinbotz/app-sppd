@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 rounded-4 mt-4 p-2">
                <div class="card-header bg-primary bg-gradient text-white rounded-4 d-flex justify-content-between align-items-center border-0" style="min-height:60px;">
                    <h4 class="mb-0 fw-bold"><i class="fas fa-file-alt me-2"></i>Detail SPPD</h4>
                    <a href="{{ url()->previous() }}" class="btn btn-light btn-sm px-3"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3 mb-2">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <div class="text-muted small fw-bold">Nama Pegawai</div>
                                <div class="fs-5">{{ $sppd->user->name ?? '-' }}</div>
                            </div>
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
                                            <li class="fs-6">{{ $nama }} / {{ $sppd->nip_pegawai[$i] ?? '' }} / {{ $sppd->jabatan_pegawai[$i] ?? '' }}</li>
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
                                        @foreach($sppd->pengikut as $p)
                                            <li class="fs-6">{{ $p }}</li>
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
                                <div class="fs-5">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 