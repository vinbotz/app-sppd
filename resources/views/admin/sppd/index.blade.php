@extends('layouts.app')

@section('content')
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
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Daftar Pengajuan SPPD</h5>
                        <div>
                            <a href="{{ route('admin.sppd.exportPdf') }}" class="btn btn-outline-danger me-2"><i class="fas fa-file-pdf me-1"></i> Export PDF</a>
                            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#exportExcelModal"><i class="fas fa-file-excel me-1"></i> Export Excel</button>
                        </div>
                    </div>

                    <!-- Modal Export Excel -->
                    <div class="modal fade" id="exportExcelModal" tabindex="-1" aria-labelledby="exportExcelModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exportExcelModalLabel">Export Excel - Pilih Kolom</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="{{ route('admin.sppd.exportExcel') }}" method="GET" target="_blank">
                            <div class="modal-body">
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fields[]" value="nama_pegawai" id="excel_nama_pegawai" checked>
                                <label class="form-check-label" for="excel_nama_pegawai">Nama Pegawai</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fields[]" value="kegiatan" id="excel_kegiatan" checked>
                                <label class="form-check-label" for="excel_kegiatan">Kegiatan</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fields[]" value="tujuan" id="excel_tujuan" checked>
                                <label class="form-check-label" for="excel_tujuan">Tujuan</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fields[]" value="tanggal_berangkat" id="excel_tanggal_berangkat" checked>
                                <label class="form-check-label" for="excel_tanggal_berangkat">Tanggal Berangkat</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fields[]" value="tanggal_kembali" id="excel_tanggal_kembali" checked>
                                <label class="form-check-label" for="excel_tanggal_kembali">Tanggal Pulang</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fields[]" value="alat_angkut" id="excel_alat_angkut" checked>
                                <label class="form-check-label" for="excel_alat_angkut">Alat Angkut</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fields[]" value="status" id="excel_status" checked>
                                <label class="form-check-label" for="excel_status">Status</label>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                              <button type="submit" class="btn btn-success">Download Excel</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
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
                                        <a href="{{ route('admin.sppd.show', $sppd->id) }}" class="btn btn-sm btn-info" title="Lihat Detail"><i class="fas fa-eye"></i></a>
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