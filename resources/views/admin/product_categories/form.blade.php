@extends('admin.layouts.app')

@section('title', isset($category) ? 'Edit Kategori Produk' : 'Tambah Kategori Produk')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.product-categories.index') }}" class="text-decoration-none text-secondary fw-semibold small">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Master Kategori
    </a>
    <h3 class="fw-bold text-dark mt-2 m-0">
        {{ isset($category) ? 'Edit Kategori Produk' : 'Tambah Kategori Produk Baru' }}
    </h3>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card card-custom p-4">
            
            <form action="{{ isset($category) ? route('admin.product-categories.update', $category->id) : route('admin.product-categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($category))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark">Nama Kategori Utama <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control rounded-3" value="{{ old('name', $category->name ?? '') }}" placeholder="Contoh: Manufaktur, Machining CNC, Fabrikasi Logam" required>
                    @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark">Unggah Logo / Foto Ikon Kategori</label>
                    <input type="file" name="icon_file" accept="image/*" class="form-control rounded-3">
                    <div class="form-text text-info small mt-1">
                        <i class="fa-solid fa-lightbulb"></i> <strong>Saran Ukuran Logo Ikon:</strong> Rekomendasi <strong>300 x 300 px</strong> atau <strong>512 x 512 px</strong> (Rasio Persegi 1:1, transparan PNG/SVG).
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark">Atau Kode Kelas Ikon FontAwesome (Opsional)</label>
                    <input type="text" name="icon" class="form-control rounded-3" value="{{ old('icon', $category->icon ?? '') }}" placeholder="Contoh: fa-solid fa-gears, fa-solid fa-microchip">
                    <div class="form-text text-muted small mt-1">Jika tidak mengunggah file gambar, Anda dapat mengetikkan kode ikon FontAwesome.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark">Subtitle / Tagline Singkat</label>
                    <input type="text" name="subtitle" class="form-control rounded-3" value="{{ old('subtitle', $category->subtitle ?? '') }}" placeholder="Contoh: Profile PVC & Extrusion Manufaktur">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark">Nama Sub-Heading Produk (Tampil Diatas Grid Produk)</label>
                    <input type="text" name="category_name" class="form-control rounded-3" value="{{ old('category_name', $category->category_name ?? '') }}" placeholder="Contoh: Profile PVC, Produk Machining CNC">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark">Deskripsi Kategori</label>
                    <textarea name="description" rows="4" class="form-control rounded-3" placeholder="Tulis deskripsi lengkap mengenai kategori layanan/produk ini...">{{ old('description', $category->description ?? '') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-dark">Gambar Banner Header Kategori</label>
                    <input type="file" name="header_img" accept="image/*" class="form-control rounded-3">
                    <div class="form-text text-info small mt-1">
                        <i class="fa-solid fa-lightbulb"></i> <strong>Saran Ukuran Banner Header:</strong> Rekomendasi <strong>1920 x 1080 px</strong> atau <strong>1746 x 1099 px</strong> (Rasio Landscape 16:9).
                    </div>

                    @if(isset($category) && $category->header_img)
                    <div class="mt-3">
                        <div class="text-muted small mb-1">Gambar Banner Saat Ini:</div>
                        <img src="{{ $category->header_image_url }}" alt="Header Preview" class="rounded-3 border img-fluid" style="max-height: 150px;">
                    </div>
                    @endif
                </div>

                <div class="d-flex gap-2 justify-content-end pt-2">
                    <a href="{{ route('admin.product-categories.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
                    <button type="submit" class="btn btn-mbe px-4">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Kategori
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
