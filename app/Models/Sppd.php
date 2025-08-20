<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sppd extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_sppd', 'user_id', 'status', 'catatan', 'approved_by', 'approved_at',
        'pengguna_anggaran', 'nama_pegawai', 'nip_pegawai', 'jabatan_pegawai', 'pangkat_golongan',
        'kegiatan', 'alat_angkut', 'tempat_berangkat', 'tempat_tujuan',
        'lama_perjalanan', 'tanggal_berangkat', 'tanggal_kembali', 'pengikut', 'tanggal_lahir_pengikut',
        'instansi', 'akun', 'keterangan'
    ];

    protected $casts = [
        'tanggal_berangkat' => 'date',
        'tanggal_kembali' => 'date',
        'approved_at' => 'datetime',
        'nama_pegawai' => 'array',
        'nip_pegawai' => 'array',
        'jabatan_pegawai' => 'array',
        'pangkat_golongan' => 'array',
        'tempat_tujuan' => 'array',
        'pengikut' => 'array',
        'tanggal_lahir_pengikut' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function calculateTotalBiaya()
    {
        $this->total_biaya = $this->biaya_transportasi + 
                            $this->biaya_penginapan + 
                            $this->biaya_makan + 
                            $this->biaya_lainnya;
        return $this->total_biaya;
    }
} 