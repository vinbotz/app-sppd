@extends('layouts.app')

@section('content')
<script>window.disablePageLoader = true;</script>
<style>
/* Nonaktifkan loading animation khusus di halaman admin dashboard */
.page-loader {
    display: none !important;
    opacity: 0 !important;
    visibility: hidden !important;
}
</style>
<div class="page-content">
<style>
  body { background: #f6f8fa; }
  .dashboard-card {
    border-radius: 1.2rem;
    box-shadow: 0 2px 12px 0 rgba(0,0,0,0.06);
    border: none;
    transition: box-shadow 0.2s, transform 0.2s;
    background: #fff;
    min-height: 140px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  .dashboard-card:hover {
    box-shadow: 0 6px 32px 0 rgba(37,99,235,0.13);
    transform: translateY(-2px) scale(1.02);
  }
  .stat-label {
    font-size: 1rem;
    color: #6b7280;
    font-weight: 500;
    margin-bottom: 0.2rem;
    letter-spacing: 0.5px;
  }
  .stat-value {
    font-size: 2.2rem;
    font-weight: 700;
    color: #2563eb;
    margin-bottom: 0.2rem;
  }
  .stat-icon {
    font-size: 2.1rem;
    margin-bottom: 0.2rem;
    color: #2563eb;
    background: none;
    border-radius: 0;
    padding: 0;
    box-shadow: none;
    display: inline-block;
  }
  .stat-card.bg-warning .stat-value, .stat-card.bg-success .stat-value, .stat-card.bg-danger .stat-value {
    color: #222 !important;
  }
  .stat-card.bg-warning .stat-label, .stat-card.bg-success .stat-label, .stat-card.bg-danger .stat-label {
    color: #222 !important;
  }
  .table-modern thead {
    background: #f3f4f6;
    font-weight: 700;
    font-size: 1.05rem;
    letter-spacing: 0.2px;
  }
  .table-modern tbody tr:hover {
    background: #f1f5f9;
  }
  .badge-status {
    font-size: 0.98rem;
    font-weight: 600;
    border-radius: 1rem;
    padding: 0.45em 1.2em;
    letter-spacing: 0.5px;
    background: #e0e7ff;
    color: #2563eb;
    border: none;
  }
  .badge-status.success { background: #d1fae5; color: #059669; }
  .badge-status.danger { background: #fee2e2; color: #dc2626; }
  .badge-status.warning { background: #fef9c3; color: #b45309; }
  .badge-status.secondary { background: #e5e7eb; color: #374151; }
  .btn-detail {
    border-radius: 2rem;
    padding: 0.4em 1.3em;
    font-weight: 500;
    font-size: 1rem;
    box-shadow: 0 2px 8px 0 rgba(37,99,235,0.07);
    transition: background 0.2s, color 0.2s;
  }
  .btn-detail:hover {
    background: #2563eb;
    color: #fff;
  }
</style>
<div class="container py-4">
  <h2 class="fw-bold mb-4" style="letter-spacing:1px;">Dashboard Admin</h2>
  <div class="row g-3 mb-4">
    <div class="col-md-3">
      <div class="card shadow-sm border-0 text-white bg-primary h-100">
        <div class="card-body d-flex flex-column align-items-center justify-content-center">
          <i class="fas fa-file-alt fa-2x mb-2"></i>
          <div class="fs-6">Total SPPD</div>
          <div class="fs-3 fw-bold">{{ $totalSppd }}</div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm border-0 text-dark bg-warning h-100">
        <div class="card-body d-flex flex-column align-items-center justify-content-center">
          <i class="fas fa-hourglass-half fa-2x mb-2"></i>
          <div class="fs-6">Menunggu</div>
          <div class="fs-3 fw-bold">{{ $sppdPending }}</div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm border-0 text-white bg-success h-100">
        <div class="card-body d-flex flex-column align-items-center justify-content-center">
          <i class="fas fa-check-circle fa-2x mb-2"></i>
          <div class="fs-6">Disetujui</div>
          <div class="fs-3 fw-bold">{{ $sppdApproved }}</div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm border-0 text-white bg-danger h-100">
        <div class="card-body d-flex flex-column align-items-center justify-content-center">
          <i class="fas fa-times-circle fa-2x mb-2"></i>
          <div class="fs-6">Ditolak</div>
          <div class="fs-3 fw-bold">{{ $sppdRejected }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="card dashboard-card mb-4">
    <div class="card-header bg-white border-0 pb-0">
      <div class="fw-bold fs-5">SPPD Terbaru</div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-modern align-middle">
          <thead>
            <tr class="text-center">
              <th>No</th>
              <th>Nama Pegawai</th>
              <th>Tujuan</th>
              <th>Tanggal Berangkat</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($sppdTerbaru as $sppd)
            <tr class="text-center">
              <td>{{ $loop->iteration }}</td>
              <td>
                @if(is_array($sppd->nama_pegawai))
                  {{ $sppd->nama_pegawai[0] ?? '-' }}@if(count($sppd->nama_pegawai) > 1) dan {{ count($sppd->nama_pegawai) - 1 }} lainnya @endif
                @else
                  {{ $sppd->nama_pegawai ?? '-' }}
                @endif
              </td>
              <td>
                @if(is_array($sppd->tempat_tujuan))
                  {{ implode(', ', $sppd->tempat_tujuan) }}
                @else
                  {{ $sppd->tempat_tujuan }}
                @endif
              </td>
              <td>{{ $sppd->tanggal_berangkat->format('d M Y') }}</td>
              <td>
                @php
                  $statusClass = '';
                  if ($sppd->status === 'disetujui') {
                    $statusClass = 'success';
                  } elseif ($sppd->status === 'ditolak') {
                    $statusClass = 'danger';
                  } elseif ($sppd->status === 'diajukan') {
                    $statusClass = 'warning';
                  } else {
                    $statusClass = 'secondary';
                  }
                @endphp
                <span class="badge-status {{ $statusClass }}">
                  {{ ucfirst($sppd->status) }}
                </span>
              </td>
              <td>
                <a href="{{ route('admin.sppd.show', $sppd->id) }}" class="btn btn-sm btn-detail px-3 shadow-sm" title="Lihat Detail">
                  <i class="fas fa-eye"></i> Detail
                </a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center text-muted">Belum ada data SPPD terbaru.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="mb-4">
  <form method="GET" action="" class="row g-2 align-items-end">
    <div class="col-auto">
      <label for="filterBulan" class="form-label mb-0">Bulan</label>
      <select name="bulan" id="filterBulan" class="form-select">
        <option value="">Semua</option>
        @foreach([1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'] as $num => $nama)
          <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>{{ $nama }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-auto">
      <label for="filterTahun" class="form-label mb-0">Tahun</label>
      <select name="tahun" id="filterTahun" class="form-select">
        <option value="">Semua</option>
        @php
          $tahunMin = $statistikTahun->min('tahun') ?? date('Y');
          $tahunMax = $statistikTahun->max('tahun') ?? date('Y');
        @endphp
        @for($thn = $tahunMin; $thn <= $tahunMax; $thn++)
          <option value="{{ $thn }}" {{ request('tahun') == $thn ? 'selected' : '' }}>{{ $thn }}</option>
        @endfor
      </select>
    </div>
    <div class="col-auto">
      <label for="filterTanggal" class="form-label mb-0">Tanggal</label>
      <input type="date" name="tanggal" id="filterTanggal" class="form-control" value="{{ request('tanggal') }}">
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-primary">Terapkan</button>
    </div>
  </form>
</div>

<!-- Judul Utama -->
<div class="text-center mb-4">
  <h1 class="fw-bold" style="color: #1e3a8a; font-size: 2.5rem; letter-spacing: 2px;">STATISTIK SPPD</h1>
</div>

<!-- Layout Dua Kolom -->
<div class="row">
  <!-- Kolom Kiri - Grafik Batang -->
  <div class="col-lg-8">
    <div class="card dashboard-card mb-4">
      <div class="card-header bg-white border-0 pb-0 d-flex align-items-center justify-content-between">
        <div class="fw-bold fs-5 mb-0" id="statistikTitle">Statistik SPPD per Tahun</div>
        <select id="statistikSelect" class="form-select w-auto" style="min-width:200px;">
          <option value="tahun" selected>Statistik SPPD per Tahun</option>
          <option value="alat">Alat Transportasi Populer</option>
        </select>
      </div>
      <div class="card-body">
        <canvas id="statistikChart" height="300" style="max-width: 100%; width: 600px; height: 300px; margin: auto; display: block;"></canvas>
      </div>
    </div>
  </div>

  <!-- Kolom Kanan - Grafik Donut -->
  <div class="col-lg-4">
    <div class="card dashboard-card mb-4">
      <div class="card-header bg-white border-0 pb-0">
        <div class="fw-bold fs-5 mb-0">Status SPPD</div>
      </div>
      <div class="card-body d-flex justify-content-center align-items-center" style="height: 350px;">
        <canvas id="statusChart" style="max-width: 100%; width: 300px; height: 300px; margin: auto; display: block;"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Grafik Kegiatan dan Tujuan -->
<div class="row">
  <div class="col-lg-6">
    <div class="card dashboard-card mb-4">
      <div class="card-header bg-white border-0 pb-0 d-flex align-items-center justify-content-between">
        <div class="fw-bold fs-5 mb-0" id="kegiatanTitle">Kegiatan Terbanyak</div>
        <select id="kegiatanChartType" class="form-select w-auto" style="min-width:120px;">
          <option value="bar" selected>Diagram Batang</option>
          <option value="line">Diagram Garis</option>
        </select>
      </div>
      <div class="card-body">
        <canvas id="kegiatanChart" height="300" style="max-width: 100%; width: 600px; height: 300px; margin: auto; display: block;"></canvas>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card dashboard-card mb-4">
      <div class="card-header bg-white border-0 pb-0 d-flex align-items-center justify-content-between">
        <div class="fw-bold fs-5 mb-0" id="tujuanTitle">Tujuan Terpopuler</div>
        <select id="tujuanChartType" class="form-select w-auto" style="min-width:120px;">
          <option value="bar" selected>Diagram Batang</option>
          <option value="line">Diagram Garis</option>
        </select>
      </div>
      <div class="card-body">
        <canvas id="tujuanChart" height="300" style="max-width: 100%; width: 600px; height: 300px; margin: auto; display: block;"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Grafik Alat Angkut -->
<div class="row">
  <div class="col-12">
    <div class="card dashboard-card mb-4">
      <div class="card-header bg-white border-0 pb-0 d-flex align-items-center justify-content-between">
        <div class="fw-bold fs-5 mb-0" id="alatTitle">Alat Angkut Populer</div>
        <select id="alatChartType" class="form-select w-auto" style="min-width:120px;">
          <option value="bar" selected>Diagram Batang</option>
          <option value="line">Diagram Garis</option>
        </select>
      </div>
      <div class="card-body">
        <canvas id="alatChart" height="300" style="max-width: 100%; width: 800px; height: 300px; margin: auto; display: block;"></canvas>
      </div>
    </div>
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
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctxStatistik = document.getElementById('statistikChart').getContext('2d');
// Data Statistik SPPD per Tahun
const tahunLabels = @json($statistikTahun->pluck('tahun') ?? []);
const totalData = @json($statistikTahun->pluck('total') ?? []);
const disetujuiData = @json($statistikTahun->pluck('disetujui') ?? []);
const ditolakData = @json($statistikTahun->pluck('ditolak') ?? []);
// Data Alat Transportasi Populer (untuk statistik per tahun)
const alatTransportasiLabels = @json($alatTransportasi->pluck('alat_angkut') ?? []);
const alatTransportasiData = @json($alatTransportasi->pluck('total') ?? []);

// Cek apakah canvas ada sebelum membuat chart
if (document.getElementById('statistikChart')) {
  let statistikChart = new Chart(ctxStatistik, {
      type: 'bar',
      data: {
          labels: tahunLabels,
          datasets: [
              {
                  label: 'Total',
                  data: totalData,
                  backgroundColor: 'rgba(54, 162, 235, 0.8)',
                  borderColor: 'rgba(54, 162, 235, 1)',
                  borderWidth: 2,
                  borderRadius: 6,
                  maxBarThickness: 50,
              },
              {
                  label: 'Disetujui',
                  data: disetujuiData,
                  backgroundColor: 'rgba(75, 192, 192, 0.8)',
                  borderColor: 'rgba(75, 192, 192, 1)',
                  borderWidth: 2,
                  borderRadius: 6,
                  maxBarThickness: 50,
              },
              {
                  label: 'Ditolak',
                  data: ditolakData,
                  backgroundColor: 'rgba(255, 99, 132, 0.8)',
                  borderColor: 'rgba(255, 99, 132, 1)',
                  borderWidth: 2,
                  borderRadius: 6,
                  maxBarThickness: 50,
              }
          ]
      },
      options: {
          responsive: true,
          plugins: {
              legend: { position: 'top' },
              title: { display: false }
          },
          scales: {
              x: { 
                  grid: { display: false },
                  ticks: {
                      color: '#333',
                      font: { weight: 'bold' }
                  }
              },
              y: { 
                  beginAtZero: true,
                  grid: {
                      color: 'rgba(0,0,0,0.1)',
                      borderDash: [5, 5]
                  },
                  ticks: {
                      color: '#333',
                      font: { weight: 'bold' }
                  }
              }
          }
      }
  });

  document.getElementById('statistikSelect').addEventListener('change', function(e) {
      const value = e.target.value;
      // Ubah judul sesuai pilihan
      const title = document.getElementById('statistikTitle');
      if (value === 'tahun') {
          title.textContent = 'Statistik SPPD per Tahun';
      } else if (value === 'alat') {
          title.textContent = 'Statistik Alat Transportasi Populer';
      }
      statistikChart.destroy();
      if (value === 'tahun') {
          statistikChart = new Chart(ctxStatistik, {
              type: 'bar',
              data: {
                  labels: tahunLabels,
                  datasets: [
                      {
                          label: 'Total',
                          data: totalData,
                          backgroundColor: 'rgba(54, 162, 235, 0.8)',
                          borderColor: 'rgba(54, 162, 235, 1)',
                          borderWidth: 2,
                          borderRadius: 6,
                          maxBarThickness: 50,
                      },
                      {
                          label: 'Disetujui',
                          data: disetujuiData,
                          backgroundColor: 'rgba(75, 192, 192, 0.8)',
                          borderColor: 'rgba(75, 192, 192, 1)',
                          borderWidth: 2,
                          borderRadius: 6,
                          maxBarThickness: 50,
                      },
                      {
                          label: 'Ditolak',
                          data: ditolakData,
                          backgroundColor: 'rgba(255, 99, 132, 0.8)',
                          borderColor: 'rgba(255, 99, 132, 1)',
                          borderWidth: 2,
                          borderRadius: 6,
                          maxBarThickness: 50,
                      }
                  ]
              },
              options: {
                  responsive: true,
                  plugins: {
                      legend: { position: 'top' },
                      title: { display: false }
                  },
                  scales: {
                      x: { 
                          grid: { display: false },
                          ticks: {
                              color: '#333',
                              font: { weight: 'bold' }
                          }
                      },
                      y: { 
                          beginAtZero: true,
                          grid: {
                              color: 'rgba(0,0,0,0.1)',
                              borderDash: [5, 5]
                          },
                          ticks: {
                              color: '#333',
                              font: { weight: 'bold' }
                          }
                      }
                  }
              }
          });
      } else if (value === 'alat') {
          statistikChart = new Chart(ctxStatistik, {
              type: 'line',
              data: {
                  labels: alatTransportasiLabels,
                  datasets: [
                      {
                          label: 'Jumlah Penggunaan',
                          data: alatTransportasiData,
                          fill: false,
                          borderColor: 'rgba(255, 99, 71, 1)',
                          backgroundColor: 'rgba(255, 99, 71, 0.2)',
                          tension: 0.4,
                          pointBackgroundColor: 'rgba(255, 99, 71, 1)',
                          pointBorderColor: '#fff',
                          pointRadius: 6,
                          pointHoverRadius: 8,
                          pointStyle: 'circle',
                          borderWidth: 3,
                      }
                  ]
              },
              options: {
                  responsive: true,
                  plugins: {
                      legend: { display: false },
                      title: { display: false }
                  },
                  scales: {
                      x: {
                          grid: {
                              display: true,
                              borderDash: [5, 5],
                              color: 'rgba(0,0,0,0.1)',
                          },
                          ticks: {
                              color: '#333',
                              font: { weight: 'bold' }
                          }
                      },
                      y: {
                          beginAtZero: true,
                          grid: {
                              display: true,
                              borderDash: [5, 5],
                              color: 'rgba(0,0,0,0.1)',
                          },
                          ticks: {
                              color: '#333',
                              font: { weight: 'bold' }
                          }
                      }
                  }
              }
          });
      }
  });
}

// Data dari backend untuk Kegiatan
const kegiatanLabels = @json($kegiatanCluster->pluck('kegiatan') ?? []);
const kegiatanData = @json($kegiatanCluster->pluck('total') ?? []);
// Data dari backend untuk Tujuan
const tujuanLabels = @json($tujuanCluster->pluck('tujuan') ?? []);
const tujuanData = @json($tujuanCluster->pluck('total') ?? []);
// Data dari backend untuk Alat Angkut (untuk chart alat angkut populer)
const alatClusterLabels = @json($alatCluster->pluck('alat_angkut') ?? []);
const alatClusterData = @json($alatCluster->pluck('total') ?? []);

let kegiatanChart;
function renderKegiatanChart(type) {
  const canvas = document.getElementById('kegiatanChart');
  if (!canvas) return;
  
  const ctx = canvas.getContext('2d');
  if (kegiatanChart) kegiatanChart.destroy();
  kegiatanChart = new Chart(ctx, {
    type: type,
    data: {
      labels: kegiatanLabels,
      datasets: [{
        label: 'Jumlah Kegiatan',
        data: kegiatanData,
        backgroundColor: type === 'bar' ? 'rgba(54, 162, 235, 0.8)' : 'rgba(54, 162, 235, 0.2)',
        borderColor: type === 'bar' ? 'rgba(54, 162, 235, 1)' : 'rgba(54, 162, 235, 1)',
        borderWidth: type === 'bar' ? 2 : 2,
        fill: type === 'line' ? false : true,
        tension: 0.4,
        pointBackgroundColor: type === 'line' ? 'rgba(54, 162, 235, 1)' : undefined,
        pointBorderColor: type === 'line' ? '#fff' : undefined,
        pointRadius: type === 'line' ? 6 : 0,
        pointHoverRadius: type === 'line' ? 8 : 0,
        borderRadius: type === 'bar' ? 6 : 0,
        maxBarThickness: type === 'bar' ? 50 : undefined,
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        title: { display: false }
      },
      scales: {
        x: {
          grid: { 
            display: true, 
            borderDash: [5,5], 
            color: 'rgba(0,0,0,0.1)' 
          },
          ticks: { 
            color: '#333', 
            font: { weight: 'bold' } 
          }
        },
        y: {
          beginAtZero: true,
          grid: { 
            display: true, 
            borderDash: [5,5], 
            color: 'rgba(0,0,0,0.1)' 
          },
          ticks: { 
            color: '#333', 
            font: { weight: 'bold' } 
          }
        }
      }
    }
  });
}

const kegiatanSelect = document.getElementById('kegiatanChartType');
if (kegiatanSelect) {
  kegiatanSelect.addEventListener('change', function(e) {
    renderKegiatanChart(e.target.value);
  });
}
// Render default
renderKegiatanChart('bar');

let tujuanChart;
function renderTujuanChart(type) {
  const canvas = document.getElementById('tujuanChart');
  if (!canvas) return;
  
  const ctx = canvas.getContext('2d');
  if (tujuanChart) tujuanChart.destroy();
  tujuanChart = new Chart(ctx, {
    type: type,
    data: {
      labels: tujuanLabels,
      datasets: [{
        label: 'Jumlah Kunjungan',
        data: tujuanData,
        backgroundColor: type === 'bar' ? 'rgba(75, 192, 192, 0.8)' : 'rgba(75, 192, 192, 0.2)',
        borderColor: type === 'bar' ? 'rgba(75, 192, 192, 1)' : 'rgba(75, 192, 192, 1)',
        borderWidth: type === 'bar' ? 2 : 2,
        fill: type === 'line' ? false : true,
        tension: 0.4,
        pointBackgroundColor: type === 'line' ? 'rgba(75, 192, 192, 1)' : undefined,
        pointBorderColor: type === 'line' ? '#fff' : undefined,
        pointRadius: type === 'line' ? 6 : 0,
        pointHoverRadius: type === 'line' ? 8 : 0,
        borderRadius: type === 'bar' ? 6 : 0,
        maxBarThickness: type === 'bar' ? 50 : undefined,
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        title: { display: false }
      },
      scales: {
        x: {
          grid: { 
            display: true, 
            borderDash: [5,5], 
            color: 'rgba(0,0,0,0.1)' 
          },
          ticks: { 
            color: '#333', 
            font: { weight: 'bold' } 
          }
        },
        y: {
          beginAtZero: true,
          grid: { 
            display: true, 
            borderDash: [5,5], 
            color: 'rgba(0,0,0,0.1)' 
          },
          ticks: { 
            color: '#333', 
            font: { weight: 'bold' } 
          }
        }
      }
    }
  });
}

const tujuanSelect = document.getElementById('tujuanChartType');
if (tujuanSelect) {
  tujuanSelect.addEventListener('change', function(e) {
    renderTujuanChart(e.target.value);
  });
}
// Render default
renderTujuanChart('bar');

let alatChart;
function renderAlatChart(type) {
  const canvas = document.getElementById('alatChart');
  if (!canvas) return;
  
  const ctx = canvas.getContext('2d');
  if (alatChart) alatChart.destroy();
  alatChart = new Chart(ctx, {
    type: type,
    data: {
      labels: alatClusterLabels,
      datasets: [{
        label: 'Jumlah Penggunaan',
        data: alatClusterData,
        backgroundColor: type === 'bar' ? 'rgba(255, 99, 132, 0.8)' : 'rgba(255, 99, 132, 0.2)',
        borderColor: type === 'bar' ? 'rgba(255, 99, 132, 1)' : 'rgba(255, 99, 132, 1)',
        borderWidth: type === 'bar' ? 2 : 2,
        fill: type === 'line' ? false : true,
        tension: 0.4,
        pointBackgroundColor: type === 'line' ? 'rgba(255, 99, 132, 1)' : undefined,
        pointBorderColor: type === 'line' ? '#fff' : undefined,
        pointRadius: type === 'line' ? 6 : 0,
        pointHoverRadius: type === 'line' ? 8 : 0,
        borderRadius: type === 'bar' ? 6 : 0,
        maxBarThickness: type === 'bar' ? 50 : undefined,
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        title: { display: false }
      },
      scales: {
        x: {
          grid: { 
            display: true, 
            borderDash: [5,5], 
            color: 'rgba(0,0,0,0.1)' 
          },
          ticks: { 
            color: '#333', 
            font: { weight: 'bold' } 
          }
        },
        y: {
          beginAtZero: true,
          grid: { 
            display: true, 
            borderDash: [5,5], 
            color: 'rgba(0,0,0,0.1)' 
          },
          ticks: { 
            color: '#333', 
            font: { weight: 'bold' } 
          }
        }
      }
    }
  });
}

const alatSelect = document.getElementById('alatChartType');
if (alatSelect) {
  alatSelect.addEventListener('change', function(e) {
    renderAlatChart(e.target.value);
  });
}
// Render default
renderAlatChart('bar');

// Grafik Donut Status SPPD
const statusCanvas = document.getElementById('statusChart');
if (statusCanvas) {
  const ctxStatus = statusCanvas.getContext('2d');
  const statusData = {
    labels: ['Diajukan', 'Disetujui', 'Ditolak'],
    datasets: [{
      data: [{{ $sppdPending }}, {{ $sppdApproved }}, {{ $sppdRejected }}],
      backgroundColor: [
        'rgba(255, 193, 7, 0.8)',   // Kuning untuk Diajukan
        'rgba(16, 185, 129, 0.8)',  // Hijau untuk Disetujui
        'rgba(239, 68, 68, 0.8)'    // Merah untuk Ditolak
      ],
      borderColor: [
        'rgba(255, 193, 7, 1)',
        'rgba(16, 185, 129, 1)',
        'rgba(239, 68, 68, 1)'
      ],
      borderWidth: 2,
      cutout: '60%'
    }]
  };

  // Hitung persentase status terbesar
  const totalStatus = {{ $sppdPending + $sppdApproved + $sppdRejected }};
  const statusArr = [{{ $sppdPending }}, {{ $sppdApproved }}, {{ $sppdRejected }}];
  const maxValue = Math.max(...statusArr);
  const maxIndex = statusArr.indexOf(maxValue);
  const maxLabel = ['Diajukan', 'Disetujui', 'Ditolak'][maxIndex];
  const maxPercent = totalStatus > 0 ? ((maxValue / totalStatus) * 100).toFixed(0) : 0;

  // Custom plugin untuk menampilkan persentase di tengah donut
  const centerTextPlugin = {
    id: 'centerText',
    afterDraw(chart) {
      const {ctx, chartArea} = chart;
      if (!chartArea) return;
      
      const {width, height, left, top} = chartArea;
      ctx.save();
      
      if (totalStatus === 0) {
        // Jika tidak ada data, tampilkan pesan
        ctx.font = 'bold 1.5rem Arial';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillStyle = '#888';
        ctx.fillText('Tidak ada data', left + width / 2, top + height / 2);
      } else {
        // Tampilkan persentase jika ada data
        ctx.font = 'bold 2.2rem Arial';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillStyle = '#222';
        ctx.fillText(maxPercent + '%', left + width / 2, top + height / 2 - 10);
        ctx.font = '1rem Arial';
        ctx.fillStyle = '#888';
        ctx.fillText(maxLabel, left + width / 2, top + height / 2 + 25);
      }
      
      ctx.restore();
    }
  };

  new Chart(ctxStatus, {
    type: 'doughnut',
    data: statusData,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            padding: 20,
            usePointStyle: true,
            font: {
              size: 12,
              weight: 'bold'
            }
          }
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              const label = context.label || '';
              const value = context.parsed;
              const total = context.dataset.data.reduce((a, b) => a + b, 0);
              const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : '0.0';
              return `${label}: ${value} (${percentage}%)`;
            }
          }
        }
      }
    },
    plugins: [centerTextPlugin]
  });
}
</script>
@endpush
</div>
@endsection 