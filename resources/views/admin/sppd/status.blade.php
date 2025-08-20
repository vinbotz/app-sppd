@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        Status Pengajuan SPPD
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-4">
                        <strong>Status Pengajuan</strong> hanya menampilkan SPPD yang masih dalam proses atau menunggu persetujuan. Untuk melihat semua pengajuan (termasuk yang sudah selesai), buka menu <strong>Riwayat Pengajuan</strong>.
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-success text-center">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama Pegawai</th>
                                    <th class="text-center">Tgl Pengajuan</th>
                                    <th class="text-center">Tujuan</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Tgl Status</th>
                                    <th class="text-center">Catatan/Alasan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $filtered = $sppds->filter(fn($sppd) => $sppd->status == 'diajukan' || $sppd->status == 'belum selesai'); @endphp
                                @forelse($filtered as $sppd)
                                <tr class="text-center" style="background:#fffbe7">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        @if(is_array($sppd->nama_pegawai))
                                            {{ $sppd->nama_pegawai[0] ?? '-' }}@if(count($sppd->nama_pegawai) > 1) dan {{ count($sppd->nama_pegawai) - 1 }} lainnya @endif
                                        @else
                                            {{ $sppd->nama_pegawai ?? '-' }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($sppd->created_at)
                                            @wibDate($sppd->created_at)
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if(is_array($sppd->tempat_tujuan))
                                            {{ implode(', ', $sppd->tempat_tujuan) }}
                                        @else
                                            {{ $sppd->tempat_tujuan ?? '-' }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-warning text-dark">
                                            {{ ucfirst($sppd->status) == 'Diajukan' ? 'Belum Selesai' : ucfirst($sppd->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($sppd->approved_at)
                                            @wibDate($sppd->approved_at)
                                        @elseif($sppd->created_at)
                                            @wibDate($sppd->created_at)
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($sppd->status == 'ditolak')
                                            <span class="text-danger">{{ $sppd->catatan ?? '-' }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.sppd.show', $sppd) }}" class="btn btn-sm btn-info" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                                        <button type="button" class="btn btn-sm btn-danger btn-hapus" data-id="{{ $sppd->id }}" title="Hapus"><i class="fas fa-trash"></i></button>
                                        <form id="form-hapus-{{ $sppd->id }}" action="{{ route('admin.sppd.destroy', $sppd->id) }}" method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Tidak ada pengajuan yang masih dalam proses.</td>
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
<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger-subtle">
        <h5 class="modal-title text-danger" id="modalHapusLabel"><i class="fas fa-trash me-2"></i>Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-5">
        <div class="text-center">
          <i class="fas fa-exclamation-triangle fa-4x text-warning mb-4"></i>
          <div class="fw-bold fs-4 mb-3">Yakin ingin menghapus SPPD ini?</div>
          <div class="text-muted fs-6">Data yang dihapus tidak dapat dikembalikan.</div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary btn-lg px-4" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger btn-lg px-4" id="btnKonfirmasiHapus">Ya, Hapus</button>
      </div>
    </div>
  </div>
</div>
@if(session('deleted'))
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
                    <h4 class="mt-3 text-success fw-bold">SPPD berhasil dihapus</h4>
                    <div class="text-muted">{{ session('deleted') }}</div>
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
@push('scripts')
<script>
    let idHapus = null;
    document.querySelectorAll('.btn-hapus').forEach(btn => {
        btn.addEventListener('click', function() {
            idHapus = this.getAttribute('data-id');
            const modal = new bootstrap.Modal(document.getElementById('modalHapus'));
            modal.show();
        });
    });
    document.getElementById('btnKonfirmasiHapus').addEventListener('click', function() {
        if(idHapus) {
            document.getElementById('form-hapus-' + idHapus).submit();
        }
    });
</script>
@endpush
@endsection 