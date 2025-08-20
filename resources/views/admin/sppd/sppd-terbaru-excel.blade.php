<style>
table {
    border-collapse: collapse;
    width: 100%;
    font-size: 12px;
}
th, td {
    border: 2px solid #333;
    padding: 7px 10px;
    vertical-align: middle;
    text-align: center;
    white-space: normal;
    word-break: break-word;
}
th {
    background: #e3e6ea;
    font-weight: bold;
}
</style>
<table>
    <thead>
        <tr>
            <th>No</th>
            @foreach($columns as $col)
                <th>
                    @switch($col)
                        @case('pengguna_anggaran') Pengguna Anggaran @break
                        @case('nama_pegawai') Nama/NIP/Jabatan @break
                        @case('kegiatan') Kegiatan @break
                        @case('alat_angkut') Alat Angkut @break
                        @case('tempat_berangkat') Tempat Berangkat @break
                        @case('tempat_tujuan') Tempat Tujuan @break
                        @case('lama_perjalanan') Lama Perjalanan @break
                        @case('tanggal_berangkat') Tanggal Berangkat @break
                        @case('tanggal_kembali') Tanggal Pulang @break
                        @case('pengikut') Pengikut/Pendamping @break
                        @case('pembebanan_anggaran') Pembebanan Anggaran @break
                        @case('keterangan') Keterangan @break
                        @default {{ ucfirst(str_replace('_',' ',$col)) }}
                    @endswitch
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($sppdList as $i => $sppd)
        <tr>
            <td>{{ $i+1 }}</td>
            @foreach($columns as $col)
                <td>
                    @switch($col)
                        @case('pengguna_anggaran')
                            {{ $sppd->pengguna_anggaran ?? '-' }}
                            @break
                        @case('nama_pegawai')
                            @if(is_array($sppd->nama_pegawai))
                                @foreach($sppd->nama_pegawai as $j => $nama)
                                    {{ $nama }} / {{ $sppd->nip_pegawai[$j] ?? '' }} / {{ $sppd->jabatan_pegawai[$j] ?? '' }}<br>
                                @endforeach
                            @else
                                {{ $sppd->nama_pegawai ?? '-' }}
                            @endif
                            @break
                        @case('kegiatan')
                            {{ $sppd->kegiatan ?? '-' }}
                            @break
                        @case('alat_angkut')
                            {{ $sppd->alat_angkut ?? '-' }}
                            @break
                        @case('tempat_berangkat')
                            {{ $sppd->tempat_berangkat ?? '-' }}
                            @break
                        @case('tempat_tujuan')
                            @if(is_array($sppd->tempat_tujuan))
                                {{ implode(', ', $sppd->tempat_tujuan) }}
                            @else
                                {{ $sppd->tempat_tujuan ?? '-' }}
                            @endif
                            @break
                        @case('lama_perjalanan')
                            {{ $sppd->lama_perjalanan ?? '-' }}
                            @break
                        @case('tanggal_berangkat')
                            {{ $sppd->tanggal_berangkat ? \Carbon\Carbon::parse($sppd->tanggal_berangkat)->format('d-m-Y') : '-' }}
                            @break
                        @case('tanggal_kembali')
                            {{ $sppd->tanggal_kembali ? \Carbon\Carbon::parse($sppd->tanggal_kembali)->format('d-m-Y') : '-' }}
                            @break
                        @case('pengikut')
                            @if(is_array($sppd->pengikut))
                                {{ implode(', ', $sppd->pengikut) }}
                            @else
                                {{ $sppd->pengikut ?? '-' }}
                            @endif
                            @break
                        @case('pembebanan_anggaran')
                            {{ $sppd->instansi ?? '-' }} {{ $sppd->akun ?? '-' }}
                            @break
                        @case('keterangan')
                            {{ $sppd->keterangan ?? '-' }}
                            @break
                        @default
                            {{ $col }}
                    @endswitch
                </td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table> 