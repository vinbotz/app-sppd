<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sppds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User yang mengajukan
            $table->string('nomor_sppd')->unique();
            $table->string('status')->default('diajukan');
            
            // Detail Surat
            $table->string('pengguna_anggaran')->nullable();
            $table->json('nama_pegawai')->nullable();
            $table->json('nip_pegawai')->nullable();
            $table->json('jabatan_pegawai')->nullable();
            $table->text('kegiatan')->nullable();
            $table->string('alat_angkut')->nullable();
            $table->string('tempat_berangkat')->nullable();
            $table->json('tempat_tujuan')->nullable(); // Bisa lebih dari 1
            $table->string('lama_perjalanan')->nullable();
            $table->date('tanggal_berangkat');
            $table->date('tanggal_kembali');
            $table->json('pengikut')->nullable();
            $table->string('instansi')->nullable();
            $table->string('akun')->nullable();
            $table->text('keterangan')->nullable();
            $table->json('tanggal_lahir_pegawai')->nullable(); // Tambahan: tanggal lahir pegawai
            // $table->json('riwayat_perjalanan')->nullable(); // Dihapus sesuai permintaan

            // Verifikasi & Catatan
            $table->text('catatan')->nullable(); // Catatan dari verifikator
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sppds');
    }
}; 