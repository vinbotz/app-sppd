<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Sppd;
use App\Models\User;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // Data SPPD milik supervisor ini saja (atau bisa semua jika supervisor melihat semua)
        $sppds = Sppd::all();
        $total = $sppds->count();
        $disetujui = $sppds->where('status', 'disetujui')->count();
        $ditolak = $sppds->where('status', 'ditolak')->count();
        $belumSelesai = $sppds->whereNotIn('status', ['disetujui', 'ditolak'])->count();
        return view('supervisor.dashboard', compact('total', 'disetujui', 'ditolak', 'belumSelesai', 'sppds'));
    }

    public function indexPengajuan()
    {
        $user = auth()->user();
        $query = \App\Models\Sppd::query();
        if (request('status')) {
            $query->where('status', request('status'));
        }
        if (request('q')) {
            $q = request('q');
            $query->where(function($sub) use ($q) {
                $sub->where('nomor_sppd', 'like', "%$q%")
                    ->orWhere('kegiatan', 'like', "%$q%")
                    ->orWhere('tempat_tujuan', 'like', "%$q%")
                    ->orWhereJsonContains('nama_pegawai', $q);
            });
        }
        $sppds = $query->orderByDesc('created_at')->paginate(15);
        return view('supervisor.index', compact('sppds'));
    }

    public function show($id)
    {
        $sppd = \App\Models\Sppd::findOrFail($id);
        
        // Normalisasi tanggal_lahir_pengikut
        if (!is_array($sppd->tanggal_lahir_pengikut)) {
            $decoded = json_decode($sppd->tanggal_lahir_pengikut, true);
            $sppd->tanggal_lahir_pengikut = is_array($decoded) ? $decoded : [];
        }
        
        return view('supervisor.show', compact('sppd'));
    }

    public function approve($id)
    {
        $sppd = Sppd::findOrFail($id);
        $sppd->status = 'disetujui';
        $sppd->approved_by = auth()->id();
        $sppd->approved_at = now();
        $sppd->catatan = null; // kosongkan alasan jika disetujui
        $sppd->save();
        // Notifikasi ke semua admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'message' => 'SPPD atas nama ' . (is_array($sppd->nama_pegawai) ? ($sppd->nama_pegawai[0] ?? '-') : ($sppd->nama_pegawai ?? '-')) . ' telah disetujui oleh supervisor.',
            ]);
        }
        return redirect()->route('supervisor.sppd.show', $id)->with('approved_sppd', 'SPPD berhasil disetujui!');
    }

    public function reject($id, \Illuminate\Http\Request $request)
    {
        $request->validate([
            'catatan' => 'required|string|max:1000',
        ]);
        $sppd = Sppd::findOrFail($id);
        $sppd->status = 'ditolak';
        $sppd->approved_by = auth()->id();
        $sppd->approved_at = now();
        $sppd->catatan = $request->catatan;
        $sppd->save();
        // Notifikasi ke semua admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'message' => 'SPPD atas nama ' . (is_array($sppd->nama_pegawai) ? ($sppd->nama_pegawai[0] ?? '-') : ($sppd->nama_pegawai ?? '-')) . ' telah tertolak oleh supervisor.',
            ]);
        }
        return redirect()->route('supervisor.sppd.show', $id)->with('rejected_sppd', 'SPPD berhasil ditolak!');
    }

    public function updateApproval($id, \Illuminate\Http\Request $request)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan' => $request->status === 'ditolak' ? 'required|string|max:1000' : 'nullable|string|max:1000',
        ]);
        $sppd = Sppd::findOrFail($id);
        $sppd->status = $request->status;
        $sppd->approved_by = auth()->id();
        $sppd->approved_at = now();
        if ($request->status === 'ditolak') {
            $sppd->catatan = $request->catatan;
        } else {
            $sppd->catatan = null; // kosongkan alasan jika disetujui
        }
        $sppd->save();
        // Notifikasi ke semua admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'message' => 'SPPD atas nama ' . (is_array($sppd->nama_pegawai) ? ($sppd->nama_pegawai[0] ?? '-') : ($sppd->nama_pegawai ?? '-')) . ' telah diedit status oleh supervisor.',
            ]);
        }
        return redirect()->route('supervisor.sppd.show', $id)->with('status_supervisor', 'Status SPPD berhasil diperbarui oleh supervisor!');
    }
} 