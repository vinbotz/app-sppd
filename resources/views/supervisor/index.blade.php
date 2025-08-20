@extends('layouts.app')

@section('content')
<script>window.disablePageLoader = true;</script>
<style>
/* Nonaktifkan loading animation khusus di halaman supervisor index */
.page-loader {
    display: none !important;
    opacity: 0 !important;
    visibility: hidden !important;
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        Daftar Pengajuan SPPD
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" class="mb-3 d-flex flex-wrap gap-2 align-items-center">
                        <label for="status" class="mb-0 fw-semibold">Filter Status:</label>
                        <select name="status" id="status" class="form-select w-auto" onchange="this.form.submit()">
                            <option value="">Semua</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Belum Selesai</option>
                        </select>
                        <input type="text" name="q" class="form-control w-auto" placeholder="Cari SPPD..." value="{{ request('q') }}">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Dewan</th>
                                    <th>Kegiatan</th>
                                    <th>Tujuan</th>
                                    <th>Tgl Berangkat</th>
                                    <th>Tgl Pulang</th>
                                    <th>Alat Angkut</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sppds as $sppd)
                                <tr class="text-center">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        @if(is_array($sppd->nama_pegawai))
                                            {{ $sppd->nama_pegawai[0] ?? '-' }}@if(count($sppd->nama_pegawai) > 1) dan {{ count($sppd->nama_pegawai) - 1 }} lainnya @endif
                                        @else
                                            {{ $sppd->nama_pegawai ?? '-' }}
                                        @endif
                                    </td>
                                    <td>{{ $sppd->kegiatan ?? '-' }}</td>
                                    <td>
                                        @if(is_array($sppd->tempat_tujuan))
                                            {{ implode(', ', $sppd->tempat_tujuan) }}
                                        @else
                                            {{ $sppd->tempat_tujuan ?? '-' }}
                                        @endif
                                    </td>
                                    <td>{{ $sppd->tanggal_berangkat ? $sppd->tanggal_berangkat->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $sppd->tanggal_kembali ? $sppd->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $sppd->alat_angkut ?? '-' }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($sppd->status == 'disetujui') bg-success 
                                            @elseif($sppd->status == 'ditolak') bg-danger 
                                            @elseif($sppd->status == 'diajukan') bg-warning
                                            @else bg-secondary @endif">
                                            {{ ucfirst($sppd->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('supervisor.sppd.show', $sppd->id) }}" class="btn btn-sm btn-info" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">Tidak ada data pengajuan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $sppds->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 