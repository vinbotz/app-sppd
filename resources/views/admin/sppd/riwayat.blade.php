@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        Riwayat Pengajuan SPPD
                    </h5>
                    <div id="export-action-btns">
                        <button class="btn btn-outline-danger btn-export me-2" id="btnExportPdf" type="button"><i class="fas fa-file-pdf me-1"></i> Export PDF</button>
                        <button class="btn btn-outline-success btn-export" id="btnExportExcel" type="button"><i class="fas fa-file-excel me-1"></i> Export Excel</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-end gap-2">
                        {{-- Semua button, form, dan script export PDF/Excel sudah dihapus total --}}
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th class="select-checkbox-col d-none"><input type="checkbox" id="checkAll"></th>
                                    <th>No</th>
                                    <th>Nama Pegawai</th>
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
                                    <td class="select-checkbox-col d-none"><input type="checkbox" class="check-sppd" value="{{ $sppd->id }}"></td>
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
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('admin.sppd.show', $sppd->id) }}" class="btn btn-sm btn-info" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                                            <button type="button" class="btn btn-sm btn-danger btn-hapus" data-id="{{ $sppd->id }}" title="Hapus SPPD"><i class="fas fa-trash"></i></button>
                                            @if($sppd->status == 'ditolak' || $sppd->status == 'diajukan')
                                                <a href="{{ route('admin.sppd.edit', $sppd->id) }}" class="btn btn-sm btn-warning" title="Edit SPPD"><i class="fas fa-edit"></i></a>
                                            @else
                                                <button class="btn btn-sm btn-warning invisible" tabindex="-1" aria-hidden="true"><i class="fas fa-edit"></i></button>
                                            @endif
                                        </div>
                                        <form id="form-hapus-{{ $sppd->id }}" action="{{ route('admin.sppd.destroy', $sppd->id) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
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
                    <div class="row">
                        <div class="col-6">
                            <div id="sppd-fields-error" class="text-danger small mt-1 d-none">pilih kolom untuk di ceklis</div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex justify-content-end mt-3 d-none" id="select-action-btns">
                                <button class="btn btn-secondary me-2" id="btnBatal">Batal</button>
                                <button class="btn btn-primary" id="btnLanjutkan">Lanjutkan</button>
                            </div>
                        </div>
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
<!-- Modal Konfirmasi Download PDF -->
<div class="modal fade" id="modalDownloadPdf" tabindex="-1" aria-labelledby="modalDownloadPdfLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary-subtle">
        <h5 class="modal-title text-primary" id="modalDownloadPdfLabel"><i class="fas fa-file-pdf me-2"></i>Konfirmasi Download PDF</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin mendownload data SPPD dalam format PDF?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="btnKonfirmasiDownloadPdf">Download PDF</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Konfirmasi Download Excel -->
<div class="modal fade" id="modalDownloadExcel" tabindex="-1" aria-labelledby="modalDownloadExcelLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success-subtle">
        <h5 class="modal-title text-success" id="modalDownloadExcelLabel"><i class="fas fa-file-excel me-2"></i>Konfirmasi Download Excel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin mendownload data SPPD dalam format Excel?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success" id="btnKonfirmasiDownloadExcel">Download Excel</button>
      </div>
    </div>
  </div>
</div>
@if(session('edited'))
    <div class="modal fade show" id="notifModal" tabindex="-1" aria-modal="true" role="dialog" style="display:block; background:rgba(0,0,0,0.3);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4 border-0" style="background:transparent;box-shadow:none;">
                <div class="bg-white rounded-4 p-4 shadow-lg d-flex flex-column align-items-center">
                    <svg width="90" height="90" viewBox="0 0 80 80">
                        <circle cx="40" cy="40" r="38" fill="#e6f9ed" stroke="#34c759" stroke-width="4"/>
                        <polyline points="25,43 37,55 57,30" fill="none" stroke="#34c759" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"></polyline>
                    </svg>
                    <h4 class="mt-3 text-success fw-bold">SPPD berhasil diperbarui!</h4>
                </div>
            </div>
        </div>
    </div>
    <script>
        setTimeout(function() {
            var notif = document.getElementById('notifModal');
            if(notif) notif.style.display = 'none';
        }, 2000);
    </script>
@endif
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
<!-- Form Export PDF (hidden) -->
<form id="formExportPdf" method="POST" action="{{ route('admin.sppd.exportPdf') }}" target="_blank" style="display:none;">
    @csrf
    <input type="hidden" name="ids" id="pdf_sppd_ids">
</form>
<!-- Form Export Excel (hidden) -->
<form id="formExportExcel" method="POST" action="{{ route('admin.sppd.exportExcel') }}" target="_blank" style="display:none;">
    @csrf
    <input type="hidden" name="ids" id="excel_sppd_ids">
</form>
@endsection 

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let exportType = null;
    let pendingExportAction = null;

    function toggleSelectMode(show) {
        document.querySelectorAll('.select-checkbox-col').forEach(col => {
            col.classList.toggle('d-none', !show);
        });
        document.querySelectorAll('.check-sppd').forEach(cb => {
            cb.checked = false;
            cb.disabled = !show;
        });
        var checkAll = document.getElementById('checkAll');
        if (checkAll) checkAll.checked = false;
        var selectActionBtns = document.getElementById('select-action-btns');
        if (selectActionBtns) selectActionBtns.classList.toggle('d-none', !show);
        var btnExportPdf = document.getElementById('btnExportPdf');
        var btnExportExcel = document.getElementById('btnExportExcel');
        if (btnExportPdf) btnExportPdf.classList.toggle('btn-active', show && exportType === 'pdf');
        if (btnExportExcel) btnExportExcel.classList.toggle('btn-active', show && exportType === 'excel');
        if (btnExportPdf) btnExportPdf.disabled = show;
        if (btnExportExcel) btnExportExcel.disabled = show;
        // Nonaktifkan semua tombol aksi saat mode export
        document.querySelectorAll('.btn-info, .btn-hapus, .btn-warning').forEach(btn => {
            if (show) {
                btn.classList.add('disabled');
                btn.style.pointerEvents = 'none';
            } else {
                btn.classList.remove('disabled');
                btn.style.pointerEvents = '';
            }
        });
    }

    // MODAL KONFIRMASI DOWNLOAD PDF/EXCEL
    var btnExportPdf = document.getElementById('btnExportPdf');
    if (btnExportPdf) btnExportPdf.addEventListener('click', function(e) {
        exportType = 'pdf';
        toggleSelectMode(true);
    });
    var btnExportExcel = document.getElementById('btnExportExcel');
    if (btnExportExcel) btnExportExcel.addEventListener('click', function(e) {
        exportType = 'excel';
        toggleSelectMode(true);
    });
    var btnKonfirmasiDownloadPdf = document.getElementById('btnKonfirmasiDownloadPdf');
    if (btnKonfirmasiDownloadPdf) btnKonfirmasiDownloadPdf.addEventListener('click', function() {
        if (pendingExportAction) {
            pendingExportAction();
            pendingExportAction = null;
        }
        var modal = bootstrap.Modal.getInstance(document.getElementById('modalDownloadPdf'));
        if (modal) modal.hide();
    });
    var btnKonfirmasiDownloadExcel = document.getElementById('btnKonfirmasiDownloadExcel');
    if (btnKonfirmasiDownloadExcel) btnKonfirmasiDownloadExcel.addEventListener('click', function() {
        if (pendingExportAction) {
            pendingExportAction();
            pendingExportAction = null;
        }
        var modal = bootstrap.Modal.getInstance(document.getElementById('modalDownloadExcel'));
        if (modal) modal.hide();
    });

    var btnBatal = document.getElementById('btnBatal');
    if (btnBatal) btnBatal.addEventListener('click', function() {
        exportType = null;
        toggleSelectMode(false);
        var btnExportPdf = document.getElementById('btnExportPdf');
        var btnExportExcel = document.getElementById('btnExportExcel');
        if (btnExportPdf) btnExportPdf.classList.remove('btn-active');
        if (btnExportExcel) btnExportExcel.classList.remove('btn-active');
        if (btnExportPdf) btnExportPdf.disabled = false;
        if (btnExportExcel) btnExportExcel.disabled = false;
        var sppdFieldsError = document.getElementById('sppd-fields-error');
        if (sppdFieldsError) sppdFieldsError.classList.add('d-none');
    });
    var checkAll = document.getElementById('checkAll');
    if (checkAll) checkAll.addEventListener('change', function() {
        document.querySelectorAll('.check-sppd').forEach(cb => cb.checked = this.checked);
    });
    var btnLanjutkan = document.getElementById('btnLanjutkan');
    if (btnLanjutkan) btnLanjutkan.addEventListener('click', function() {
        const checked = Array.from(document.querySelectorAll('.check-sppd:checked')).map(cb => cb.value);
        var sppdFieldsError = document.getElementById('sppd-fields-error');
        if (checked.length === 0) {
            if (sppdFieldsError) sppdFieldsError.classList.remove('d-none');
            return;
        } else {
            if (sppdFieldsError) sppdFieldsError.classList.add('d-none');
        }
        // Tampilkan modal konfirmasi download sesuai tipe export
        if (exportType === 'pdf') {
            const modal = new bootstrap.Modal(document.getElementById('modalDownloadPdf'));
            modal.show();
            pendingExportAction = function() {
                document.getElementById('pdf_sppd_ids').value = checked.join(',');
                document.getElementById('formExportPdf').submit();
            };
        } else if (exportType === 'excel') {
            const modal = new bootstrap.Modal(document.getElementById('modalDownloadExcel'));
            modal.show();
            pendingExportAction = function() {
                document.getElementById('excel_sppd_ids').value = checked.join(',');
                document.getElementById('formExportExcel').submit();
            };
        }
    });
    // TOMBOL HAPUS
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
});
</script>
@endpush 

@push('styles')
<style>
.btn-active {
    font-weight: bold !important;
    box-shadow: 0 2px 8px 0 rgba(37,99,235,0.10);
    border-width: 2.5px !important;
    opacity: 1 !important;
    outline: 2px solid #2563eb33;
}
.btn-export#btnExportPdf.btn-active {
    background: #dc3545 !important;
    color: #fff !important;
    border-color: #dc3545 !important;
}
.btn-export#btnExportExcel.btn-active {
    background: #198754 !important;
    color: #fff !important;
    border-color: #198754 !important;
}
@media (max-width: 576px) {
    .table th, .table td { font-size: 13px; padding: 6px 4px; }
    .btn, .btn-sm { font-size: 13px; padding: 6px 10px; }
    .card { margin-bottom: 1rem; }
    .navbar .navbar-brand { font-size: 1rem; }
    .navbar-nav .nav-link { font-size: 1rem; padding: 8px 10px; }
    .modal-content { font-size: 14px; }
}
</style>
@endpush 