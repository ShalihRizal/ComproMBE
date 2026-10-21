@extends('admin.layouts.app')

@section('title', isset($product) ? 'Edit Produk' : 'Tambah Produk Baru')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.products.index') }}" class="text-decoration-none text-secondary fw-semibold small">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Master Produk
    </a>
    <h3 class="fw-bold text-dark mt-2 m-0">
        {{ isset($product) ? 'Edit Produk' : 'Tambah Produk Baru' }}
    </h3>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card card-custom p-4">
            
            <form action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($product))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark">Pilih Kategori Produk <span class="text-danger">*</span></label>
                    <select name="product_category_id" required class="form-select rounded-3">
                        <option value="">-- Pilih Kategori Produk --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('product_category_id', $product->product_category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_category_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark">Nama Produk <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control rounded-3" value="{{ old('name', $product->name ?? '') }}" placeholder="Contoh: Profile PVC Duct Cable, Heavy Duty PU Caster Swivel" required>
                    @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark">Spesifikasi / Ukuran / Bahan</label>
                    <input type="text" name="specs" class="form-control rounded-3" value="{{ old('specs', $product->specs ?? '') }}" placeholder="Contoh: 60 x 40, Stainless Steel 304, Cap 500kg">
                    <div class="form-text text-muted small mt-1">Akan tampil sebagai keterangan kecil di bawah nama produk.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark">Deskripsi / Catatan Produk (Opsional)</label>
                    <textarea name="description" rows="3" class="form-control rounded-3" placeholder="Tuliskan keterangan tambahan mengenai produk ini jika ada...">{{ old('description', $product->description ?? '') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-dark">Unggah Foto Produk {{ isset($product) ? '(Biarkan kosong jika tidak ingin mengubah foto)' : '' }} <span class="text-danger">*</span></label>
                    <input type="file" name="image" accept="image/*" id="productImageInput" onchange="previewProductImage(this)" class="form-control rounded-3" {{ isset($product) ? '' : 'required' }}>
                    
                    <div class="form-text text-info small mt-1">
                        <i class="fa-solid fa-lightbulb"></i> <strong>Saran Ukuran Gambar Produk:</strong> Rekomendasi <strong>1746 x 1099 px</strong> atau <strong>1200 x 800 px</strong> (Rasio Landscape 3:2 / 4:3) agar tampilan katalog konsisten & rapi.
                    </div>

                    @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror

                    <div id="productImagePreviewContainer" class="mt-3" style="display: {{ isset($product) && $product->image ? 'block' : 'none' }};">
                        <div class="text-muted small mb-1">Pratinjau Foto Produk Saat Ini:</div>
                        <img id="productImagePreview" src="{{ isset($product) ? $product->image_url : '' }}" alt="Preview Foto Produk" class="rounded-3 border img-fluid p-1 bg-white" style="max-height: 180px;">
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-end pt-2">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
                    <button type="submit" class="btn btn-mbe px-4">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Produk
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@push('scripts')
<script>
function previewProductImage(input) {
    const preview = document.getElementById('productImagePreview');
    const container = document.getElementById('productImagePreviewContainer');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

@endsection
