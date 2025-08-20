@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        @if(Auth::check() && Auth::user()->role == 'admin')
                            Daftar Pengajuan SPPD
                        @elseif(request()->query('status'))
                            Status Pengajuan SPPD
                        @else
                            Riwayat Pengajuan SPPD
                        @endif
                    </h5>
                    @if(Auth::check() && Auth::user()->role !== 'admin')
                        <a href="{{ route('sppd.create') }}" class="btn btn-primary">Buat SPPD Baru</a>
                    @endif
                </div>

                <div class="card-body">
                    @if (session('success'))
                        @php
                            $isDelete = str_contains(session('success'), 'dihapus');
                        @endphp
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
                                <h3 class="success-title">
                                    @if($isDelete)
                                        SPPD Berhasil Dihapus!
                                    @else
                                        SPPD Berhasil Diajukan!
                                    @endif
                                </h3>
                                <p class="success-message">
                                    @if($isDelete)
                                        Dokumen perjalanan dinas telah berhasil dihapus dari sistem.
                                    @else
                                        Dokumen perjalanan dinas Anda telah berhasil dikirim dan menunggu persetujuan.
                                    @endif
                                </p>
                                <button id="closeBtn" class="close-button">Tutup</button>
                            </div>
                        </div>
                        <script>
                            document.getElementById('closeBtn').onclick = function() {
                                var notif = document.querySelector('.success-notification');
                                if(notif) notif.remove();
                                @if($isDelete)
                                    window.location.href = window.location.href.split('?')[0];
                                @endif
                            };
                            setTimeout(function() {
                                var notif = document.querySelector('.success-notification');
                                if(notif) notif.remove();
                                @if($isDelete)
                                    window.location.href = window.location.href.split('?')[0];
                                @endif
                            }, 2000);
                        </script>
                    @endif

                    <div class="table-responsive">
                        @if(Auth::check() && Auth::user()->role == 'admin')
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pegawai</th>
                                    <th>Maksud</th>
                                    <th>Tujuan</th>
                                    <th>Tgl Berangkat</th>
                                    <th>Tgl Pulang</th>
                                    <th>Transportasi</th>
                                    <th>Total Biaya</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sppds as $sppd)
                                <tr class="text-center">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $sppd->user->name ?? '-' }}</td>
                                    <td>{{ $sppd->maksud_perjalanan }}</td>
                                    <td>{{ $sppd->tempat_tujuan }}</td>
                                    <td>{{ $sppd->tanggal_berangkat ? $sppd->tanggal_berangkat->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $sppd->tanggal_kembali ? $sppd->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $sppd->transportasi }}</td>
                                    <td>Rp {{ number_format($sppd->total_biaya, 0, ',', '.') }}</td>
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
                                        <a href="{{ route('sppd.show', $sppd->id) }}" class="btn btn-sm btn-info" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">Tidak ada data pengajuan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @elseif(request()->query('status'))
                        <div class="mb-3">
                            <span class="badge bg-success fs-6"><i class="fas fa-tasks me-1"></i> Status Pengajuan</span>
                        </div>
                        <p class="text-muted mb-2">Hanya menampilkan pengajuan SPPD yang masih dalam proses (belum disetujui/ditolak).</p>
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-success text-center">
                                <tr>
                                    <th class="text-center">No</th>
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
                                    <td class="text-center">{{ $sppd->created_at ? @wibDate($sppd->created_at) : '-' }}</td>
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
                                    <td class="text-center">{{ $sppd->approved_at ? @wibDate($sppd->approved_at) : ($sppd->created_at ? @wibDate($sppd->created_at) : '-') }}</td>
                                    <td class="text-center">
                                        @if($sppd->status == 'ditolak')
                                            <span class="text-danger">{{ $sppd->catatan ?? '-' }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('sppd.show', $sppd) }}" class="btn btn-sm btn-info" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Tidak ada pengajuan yang masih dalam proses.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @else
                        <table class="table table-bordered table-hover align-middle shadow-sm table-modern">
                            <thead>
                                <tr class="text-center align-middle">
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nomor SPPD</th>
                                    <th class="text-center">Nama Pegawai</th>
                                    <th class="text-center">Kegiatan</th>
                                    <th class="text-center">Tempat Berangkat</th>
                                    <th class="text-center">Tempat Tujuan</th>
                                    <th class="text-center">Tanggal Berangkat</th>
                                    <th class="text-center">Tanggal Pulang</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sppds as $i => $sppd)
                                <tr class="text-center">
                                    <td>{{ $i+1 }}</td>
                                    <td>{{ $sppd->nomor_sppd ?? '-' }}</td>
                                    <td>{{ $sppd->user->name ?? '-' }}</td>
                                    <td>{{ $sppd->kegiatan ?? '-' }}</td>
                                    <td>{{ $sppd->tempat_berangkat ?? '-' }}</td>
                                    <td>
                                        @if(is_array($sppd->tempat_tujuan))
                                            {{ implode(', ', $sppd->tempat_tujuan) }}
                                        @else
                                            {{ $sppd->tempat_tujuan ?? '-' }}
                                        @endif
                                    </td>
                                    <td>{{ $sppd->tanggal_berangkat ? $sppd->tanggal_berangkat->format('d-m-Y') : '-' }}</td>
                                    <td>{{ $sppd->tanggal_kembali ? $sppd->tanggal_kembali->format('d-m-Y') : '-' }}</td>
                                    <td>
                                        @if($sppd->status == 'disetujui')
                                            <span class="badge bg-success px-3 py-2">Disetujui</span>
                                        @elseif($sppd->status == 'ditolak')
                                            <span class="badge bg-danger px-3 py-2">Ditolak</span>
                                        @else
                                            <span class="badge bg-warning text-dark px-3 py-2">Belum Selesai</span>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- aksi -->
                                        @include('sppd.partials.aksi', ['sppd' => $sppd])
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
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