@extends('admin.layouts.app')

@section('title', 'Master Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h3 class="fw-bold text-dark m-0">Master Produk</h3>
        <p class="text-muted small m-0 mt-1">Kelola seluruh item produk dan hubungkan ke kategori masing-masing.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-mbe d-inline-flex align-items-center gap-2">
        <i class="fa-solid fa-plus"></i> Tambah Produk Baru
    </a>
</div>

<!-- FILTER & SEARCH CARD -->
<div class="card card-custom p-3 mb-4">
    <form action="{{ route('admin.products.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-4">
            <select name="category_id" class="form-select rounded-3" onchange="this.form.submit()">
                <option value="">-- Semua Kategori Produk --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-8">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control rounded-start-3" placeholder="Cari nama produk atau spesifikasi...">
                <button type="submit" class="btn btn-mbe rounded-0"><i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                @if(request('category_id') || request('search'))
                <a href="{{ route('admin.products.index') }}" class="btn btn-light border rounded-end-3">Reset</a>
                @endif
            </div>
        </div>
    </form>
</div>

<!-- PRODUCTS TABLE CARD -->
<div class="card card-custom p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr class="text-secondary fs-7">
                    <th style="width: 50px;">No</th>
                    <th style="width: 80px;">Gambar</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Spesifikasi / Ukuran</th>
                    <th class="text-end" style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $index => $prod)
                <tr>
                    <td class="fw-semibold text-secondary">{{ $products->firstItem() + $index }}</td>
                    <td>
                        <img src="{{ $prod->image_url }}" alt="{{ $prod->name }}" class="rounded-3 border object-fit-cover" style="width: 65px; height: 45px;">
                    </td>
                    <td>
                        <div class="fw-bold text-dark">{{ $prod->name }}</div>
                    </td>
                    <td>
                        <span class="badge bg-info-subtle text-info-emphasis rounded-pill px-3 py-2 fw-bold">
                            {{ $prod->category->name ?? 'Uncategorized' }}
                        </span>
                    </td>
                    <td class="text-secondary small">{{ $prod->specs ?? '-' }}</td>
                    <td class="text-end">
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.products.edit', $prod->id) }}" class="btn btn-sm btn-outline-info rounded-circle" style="width: 32px; height: 32px;" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $prod->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" class="m-0">
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
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="fa-solid fa-boxes-stacked fs-1 mb-2 d-block text-secondary"></i>
                        Belum ada produk yang ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
    <div class="mt-3 px-2">
        {{ $products->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
