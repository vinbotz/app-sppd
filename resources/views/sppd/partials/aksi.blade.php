@php $isStaff = Auth::check() && Auth::user()->role === 'admin'; @endphp
<div class="d-flex justify-content-center align-items-center gap-1">
<a href="{{ route('sppd.show', $sppd) }}" class="btn btn-sm btn-info mb-1" title="Lihat Detail"><i class="fas fa-eye"></i></a>
@if($isStaff && $sppd->status == 'diajukan')
    <a href="{{ route('sppd.edit', $sppd) }}" class="btn btn-sm btn-warning mb-1" title="Edit"><i class="fas fa-edit"></i></a>
@endif
@if($isStaff)
    <form action="{{ route('sppd.destroy', $sppd) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');" style="margin-bottom:0;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
    </form>
@endif
</div> 