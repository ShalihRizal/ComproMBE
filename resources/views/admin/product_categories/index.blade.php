@extends('admin.layouts.app')

@section('title', 'Master Kategori Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h3 class="fw-bold text-dark m-0">Master Kategori Produk</h3>
        <p class="text-muted small m-0 mt-1">Kelola kategori untuk mengelompokkan katalog produk website.</p>
    </div>
    <a href="{{ route('admin.product-categories.create') }}" class="btn btn-mbe d-inline-flex align-items-center gap-2">
        <i class="fa-solid fa-plus"></i> Tambah Kategori Baru
    </a>
</div>

<div class="card card-custom p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr class="text-secondary fs-7">
                    <th style="width: 50px;">No</th>
                    <th style="width: 70px;">Ikon</th>
                    <th>Nama Kategori</th>
                    <th>Subtitle</th>
                    <th>Sub-heading</th>
                    <th class="text-center">Jumlah Produk</th>
                    <th class="text-end" style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $index => $cat)
                <tr>
                    <td class="fw-semibold text-secondary">{{ $categories->firstItem() + $index }}</td>
                    <td>
                        <div class="bg-light rounded-3 p-2 d-flex align-items-center justify-content-center border" style="width: 42px; height: 42px;">
                            {!! $cat->icon_html !!}
                        </div>
                    </td>
                    <td>
                        <div class="fw-bold text-dark">{{ $cat->name }}</div>
                        <div class="text-muted small">Slug: {{ $cat->slug }}</div>
                    </td>
                    <td class="text-secondary small">{{ $cat->subtitle ?? '-' }}</td>
                    <td class="text-secondary small">{{ $cat->category_name ?? '-' }}</td>
                    <td class="text-center">
                        <span class="badge bg-info-subtle text-info-emphasis rounded-pill px-3 py-2 fw-bold">
                            {{ $cat->products_count }} Produk
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.product-categories.edit', $cat->id) }}" class="btn btn-sm btn-outline-info rounded-circle" style="width: 32px; height: 32px;" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.product-categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini beserta seluruh produk di dalamnya?');" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" style="width: 32px; height: 32px;" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="fa-solid fa-folder-open fs-1 mb-2 d-block text-secondary"></i>
                        Belum ada kategori produk. Klik tombol "Tambah Kategori Baru" untuk membuat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())
    <div class="mt-3 px-2">
        {{ $categories->links() }}
    </div>
    @endif
</div>
@endsection
