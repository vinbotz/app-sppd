<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sppd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $tanggal = $request->input('tanggal');

        // Query dasar
        $sppdQuery = Sppd::query();
        if ($bulan) {
            $sppdQuery->whereMonth('created_at', $bulan);
        }
        if ($tahun) {
            $sppdQuery->whereYear('created_at', $tahun);
        }
        if ($tanggal) {
            $sppdQuery->whereDate('created_at', $tanggal);
        }

        // Cluster Kegiatan Terbanyak
        $kegiatanCluster = (clone $sppdQuery)
            ->select('kegiatan', DB::raw('COUNT(*) as total'))
            ->groupBy('kegiatan')
            ->orderByDesc('total')
            ->limit(7)
            ->get();

        // Cluster Tujuan Terpopuler
        $tujuanCluster = (clone $sppdQuery)
            ->select(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(tempat_tujuan, "$[0]")) as tujuan'), DB::raw('COUNT(*) as total'))
            ->groupBy('tujuan')
            ->orderByDesc('total')
            ->limit(7)
            ->get();

        // Cluster Alat Angkut Populer
        $alatCluster = (clone $sppdQuery)
            ->select('alat_angkut', DB::raw('COUNT(*) as total'))
            ->groupBy('alat_angkut')
            ->orderByDesc('total')
            ->limit(7)
            ->get();

        // Statistik SPPD
        $totalSppd = Sppd::count();
        $sppdPending = Sppd::where('status', 'diajukan')->count();
        $sppdApproved = Sppd::where('status', 'disetujui')->count();
        $sppdRejected = Sppd::where('status', 'ditolak')->count();

        // Total biaya per bulan
        // $biayaPerBulan = Sppd::where('status', 'disetujui')
        //     ->whereYear('created_at', date('Y'))
        //     ->select(
        //         DB::raw('MONTH(created_at) as bulan'),
        //         DB::raw('SUM(total_biaya) as total')
        //     )
        //     ->groupBy('bulan')
        //     ->get();
        $biayaPerBulan = collect(); // Kosongkan agar tidak error

        // SPPD Terbaru: ambil 5 SPPD terbaru secara global
        $sppdTerbaru = Sppd::with(['user', 'approver'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Pengguna Aktif
        // $penggunaAktif = User::where('last_login_at', '>=', now()->subDays(30))
        //     ->count();

        // Statistik SPPD per Tahun
        $statistikTahun = Sppd::selectRaw('YEAR(created_at) as tahun')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN status = "disetujui" THEN 1 ELSE 0 END) as disetujui')
            ->selectRaw('SUM(CASE WHEN status = "ditolak" THEN 1 ELSE 0 END) as ditolak')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        // Alat Transportasi Terpopuler
        $alatTransportasi = Sppd::select('alat_angkut', DB::raw('COUNT(*) as total'))
            ->groupBy('alat_angkut')
            ->orderByDesc('total')
            ->limit(7)
            ->get();

        // Tujuan Terpopuler
        $tujuanTerpopuler = Sppd::select(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(tempat_tujuan, "$[0]")) as tujuan'), DB::raw('COUNT(*) as total'))
            ->groupBy('tujuan')
            ->orderByDesc('total')
            ->limit(7)
            ->get();

        return view('admin.dashboard', compact(
            'totalSppd',
            'sppdPending',
            'sppdApproved',
            'sppdRejected',
            'biayaPerBulan',
            'sppdTerbaru',
            'statistikTahun',
            'alatTransportasi',
            'tujuanTerpopuler',
            'kegiatanCluster',
            'tujuanCluster',
            'alatCluster',
            // 'penggunaAktif' dihapus
        ));
    }

    public function exportPdf(Request $request)
    {
        $ids = $request->input('ids');
        $query = Sppd::with(['user', 'approver'])->orderByDesc('created_at');
        if ($ids) {
            $idArray = explode(',', $ids);
            $query->whereIn('id', $idArray);
        }
        $sppdList = $query->get();
        // Normalisasi tanggal_lahir_pengikut agar selalu array tanggal valid/null
        foreach ($sppdList as $sppd) {
            // Normalisasi tanggal_lahir_pengikut
            if (!is_array($sppd->tanggal_lahir_pengikut)) {
                $decoded = json_decode($sppd->tanggal_lahir_pengikut, true);
                $sppd->tanggal_lahir_pengikut = is_array($decoded) ? $decoded : [];
            }
            if (!is_array($sppd->tanggal_lahir_pengikut)) {
                $sppd->tanggal_lahir_pengikut = [];
            }
            foreach ($sppd->tanggal_lahir_pengikut as $k => $tgl) {
                // Jika kosong, '[', atau bukan tanggal valid, set null
                if (!$tgl || $tgl === '[' || !strtotime($tgl)) {
                    $sppd->tanggal_lahir_pengikut[$k] = null;
                }
            }
        }
        $columns = $request->input('fields', []);
        $pdf = Pdf::loadView('admin.sppd.sppd-terbaru-pdf', compact('sppdList', 'columns'));
        return $pdf->download('SPPD Terbaru ' . date('d-m-Y') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $ids = $request->input('ids');
        $query = Sppd::with(['user', 'approver'])->orderByDesc('created_at');
        if ($ids) {
            $idArray = explode(',', $ids);
            $query->whereIn('id', $idArray);
        }
        $sppdList = $query->get();
        // Kolom default untuk Excel
        $columns = [
            'pengguna_anggaran', 'nama_pegawai', 'kegiatan', 'alat_angkut', 'tempat_berangkat',
            'tempat_tujuan', 'lama_perjalanan', 'tanggal_berangkat', 'tanggal_kembali',
            'pengikut', 'pembebanan_anggaran', 'keterangan'
        ];
        $export = new \App\Exports\SppdTerbaruExport($sppdList, $columns);
        return \Maatwebsite\Excel\Facades\Excel::download($export, 'SPPD Terbaru ' . date('d-m-Y') . '.xlsx');
    }
} 