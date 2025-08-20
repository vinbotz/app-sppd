<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sppd;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;

class SppdController extends Controller
{
    public function index()
    {
        $sppds = \App\Models\Sppd::with('user')->latest()->paginate(15);
        return view('admin.sppd.index', compact('sppds'));
    }

    public function show($id)
    {
        $sppd = Sppd::with('user')->findOrFail($id);
        
        // Normalisasi tanggal_lahir_pengikut
        if (!is_array($sppd->tanggal_lahir_pengikut)) {
            $decoded = json_decode($sppd->tanggal_lahir_pengikut, true);
            $sppd->tanggal_lahir_pengikut = is_array($decoded) ? $decoded : [];
        }
        
        return view('admin.sppd.show', compact('sppd'));
    }

    public function approve($id)
    {
        $sppd = Sppd::findOrFail($id);
        $sppd->status = 'disetujui';
        $sppd->approved_by = auth()->id();
        $sppd->approved_at = now();
        $sppd->save();
        // Notifikasi ke semua admin jika supervisor yang approve
        if (auth()->user()->role == 'supervisor') {
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'message' => 'SPPD atas nama ' . (is_array($sppd->nama_pegawai) ? ($sppd->nama_pegawai[0] ?? '-') : ($sppd->nama_pegawai ?? '-')) . ' telah disetujui oleh supervisor.',
                ]);
            }
            return redirect()->route('supervisor.sppd.show', $id)->with('success', 'SPPD berhasil disetujui!');
        }
        return redirect()->route('admin.sppd.show', $id)->with('success', 'SPPD berhasil disetujui!');
    }

    public function reject($id, Request $request)
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
        // Notifikasi ke semua admin jika supervisor yang reject
        if (auth()->user()->role == 'supervisor') {
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'message' => 'SPPD atas nama ' . (is_array($sppd->nama_pegawai) ? ($sppd->nama_pegawai[0] ?? '-') : ($sppd->nama_pegawai ?? '-')) . ' telah tertolak oleh supervisor.',
                ]);
            }
            return redirect()->route('supervisor.sppd.show', $id)->with('error', 'SPPD telah ditolak!');
        }
        return redirect()->route('admin.sppd.show', $id)->with('success', 'SPPD berhasil ditolak!');
    }

    public function updateApproval($id, Request $request)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan' => 'nullable|string|max:1000',
        ]);
        $sppd = Sppd::findOrFail($id);
        $sppd->status = $request->status;
        $sppd->catatan = $request->catatan;
        $sppd->approved_by = auth()->id();
        $sppd->approved_at = now();
        $sppd->save();
        // Notifikasi ke semua admin jika supervisor yang update status
        if (auth()->user()->role == 'supervisor') {
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'message' => 'SPPD atas nama ' . (is_array($sppd->nama_pegawai) ? ($sppd->nama_pegawai[0] ?? '-') : ($sppd->nama_pegawai ?? '-')) . ' telah diedit status oleh supervisor.',
                ]);
            }
            return redirect()->route('supervisor.sppd.show', $id)->with('status_supervisor', 'Status SPPD berhasil diperbarui oleh supervisor!');
        }
        return redirect()->route('admin.sppd.show', $id)->with('success', 'Status SPPD berhasil diperbarui!');
    }

    public function create()
    {
        return view('admin.sppd.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pengguna_anggaran' => 'required|string|max:255',
            'kegiatan' => 'required|string',
            'alat_angkut' => 'required|string|max:255',
            'tempat_berangkat' => 'required|string|max:255',
            'lama_perjalanan' => 'required|string|max:255',
            'tanggal_berangkat' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_berangkat',
            'instansi' => 'required|string|max:255',
            'akun' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'nama_pegawai' => 'required|array|min:1',
            'nama_pegawai.*' => 'required|string|max:255',
            'nip_pegawai' => 'required|array|min:1',
            'nip_pegawai.*' => 'required|string|max:255',
            'jabatan_pegawai' => 'required|array|min:1',
            'jabatan_pegawai.*' => 'required|string|max:255',
            'tempat_tujuan' => 'required|array|min:1',
            'tempat_tujuan.*' => 'required|string|max:255',
            'pengikut' => 'nullable|array',
            'pengikut.*' => 'nullable|string|max:255',
            'tanggal_lahir_pengikut' => 'nullable|array',
            'tanggal_lahir_pengikut.*' => 'nullable|date',
            'pangkat_golongan' => 'nullable|array',
            'pangkat_golongan.*' => 'nullable|string|max:255',
        ]);
        $validated['user_id'] = auth()->id();
        $validated['nomor_sppd'] = 'SPPD-' . date('Ymd') . '-' . strtoupper(uniqid());
        $validated['status'] = 'diajukan';
        $validated['tanggal_lahir_pengikut'] = $request->input('tanggal_lahir_pengikut');
        $sppd = \App\Models\Sppd::create($validated);
        // Notifikasi ke supervisor
        $supervisors = User::where('role', 'supervisor')->get();
        foreach ($supervisors as $supervisor) {
            Notification::create([
                'user_id' => $supervisor->id,
                'message' => 'SPPD baru atas nama ' . (is_array($sppd->nama_pegawai) ? ($sppd->nama_pegawai[0] ?? '-') : ($sppd->nama_pegawai ?? '-')) . ' telah diajukan oleh admin.',
            ]);
        }
        return redirect()->route('admin.sppd.create')->with('success', 'SPPD berhasil diajukan.');
    }

    public function edit($id)
    {
        $sppd = \App\Models\Sppd::findOrFail($id);
        
        // Normalisasi tanggal_lahir_pengikut
        if (!is_array($sppd->tanggal_lahir_pengikut)) {
            $decoded = json_decode($sppd->tanggal_lahir_pengikut, true);
            $sppd->tanggal_lahir_pengikut = is_array($decoded) ? $decoded : [];
        }
        
        return view('admin.sppd.edit', compact('sppd'));
    }

    public function update(Request $request, $id)
    {
        $sppd = \App\Models\Sppd::findOrFail($id);
        $validated = $request->validate([
            'pengguna_anggaran' => 'required|string|max:255',
            'kegiatan' => 'required|string',
            'alat_angkut' => 'required|string|max:255',
            'tempat_berangkat' => 'required|string|max:255',
            'lama_perjalanan' => 'required|string|max:255',
            'tanggal_berangkat' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_berangkat',
            'instansi' => 'required|string|max:255',
            'akun' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'nama_pegawai' => 'required|array|min:1',
            'nama_pegawai.*' => 'required|string|max:255',
            'nip_pegawai' => 'required|array|min:1',
            'nip_pegawai.*' => 'required|string|max:255',
            'jabatan_pegawai' => 'nullable|array',
            'jabatan_pegawai.*' => 'nullable|string|max:255',
            'pangkat_golongan' => 'nullable|array',
            'pangkat_golongan.*' => 'nullable|string|max:255',
            'tempat_tujuan' => 'required|array|min:1',
            'tempat_tujuan.*' => 'required|string|max:255',
            'pengikut' => 'nullable|array',
            'pengikut.*' => 'nullable|string|max:255',
            'tanggal_lahir_pengikut' => 'nullable|array',
            'tanggal_lahir_pengikut.*' => 'nullable|date',
        ]);
        $validated['tanggal_lahir_pengikut'] = $request->input('tanggal_lahir_pengikut');
        $sppd->update($validated);
        // Notifikasi ke supervisor
        $supervisors = User::where('role', 'supervisor')->get();
        foreach ($supervisors as $supervisor) {
            Notification::create([
                'user_id' => $supervisor->id,
                'message' => 'SPPD atas nama ' . (is_array($sppd->nama_pegawai) ? ($sppd->nama_pegawai[0] ?? '-') : ($sppd->nama_pegawai ?? '-')) . ' telah diedit oleh admin.',
            ]);
        }
        // Redirect sesuai role
        if (auth()->user()->role == 'supervisor') {
            return redirect()->route('supervisor.sppd.show', $id)->with('edited_supervisor', 'SPPD berhasil diedit oleh supervisor!');
        }
        return redirect()->route('admin.sppd.riwayat')->with('edited', 'SPPD berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $sppd = \App\Models\Sppd::findOrFail($id);
        $sppd->delete();
        // Redirect sesuai role
        if (auth()->user()->role == 'supervisor') {
            return redirect()->route('supervisor.sppd.riwayat')->with('deleted', 'SPPD berhasil dihapus.');
        }
        return redirect()->route('admin.sppd.riwayat')->with('deleted', 'SPPD berhasil dihapus.');
    }

    public function status()
    {
        $sppds = \App\Models\Sppd::with('user')->latest()->paginate(15);
        return view('admin.sppd.status', compact('sppds'));
    }

    public function riwayat()
    {
        $sppds = \App\Models\Sppd::with('user')->where('user_id', auth()->id())->orderBy('created_at', 'asc')->paginate(15);
        return view('admin.sppd.riwayat', compact('sppds'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $sppd = \App\Models\Sppd::findOrFail($id);
        $sppd->status = $request->status;
        $sppd->save();

        return redirect()->route('admin.sppd.show', $id)
                         ->with('success', 'Status berhasil diperbarui.');
    }
} 