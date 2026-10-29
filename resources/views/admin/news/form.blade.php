@extends('admin.layouts.app')

@section('title', isset($news) ? 'Edit Berita & Analisis SEO' : 'Tambah Berita Baru (CMS MBE)')

@push('styles')
<style>
    .form-label {
        font-weight: 700;
        font-size: 0.88rem;
        color: #1e293b;
        margin-bottom: 6px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .form-control-custom {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.2s;
        background-color: #ffffff;
    }
    .form-control-custom:focus {
        border-color: #0191b3;
        box-shadow: 0 0 0 3px rgba(1, 145, 179, 0.15);
        outline: none;
    }
    .char-counter {
        font-size: 0.78rem;
        font-weight: 600;
        color: #64748b;
    }
    .char-counter.good { color: #00a859; }
    .char-counter.warning { color: #ff9800; }
    .char-counter.danger { color: #f44336; }

    /* Card styling */
    .card-editor {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    /* Google Snippet Preview */
    .serp-preview-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 18px 20px;
        font-family: Arial, sans-serif;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }
    .serp-source {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.82rem;
        color: #202124;
        margin-bottom: 4px;
    }
    .serp-source img {
        width: 16px;
        height: 16px;
        border-radius: 50%;
    }
    .serp-breadcrumb {
        color: #4d5156;
        font-size: 0.78rem;
    }
    .serp-title {
        color: #1a0dab;
        font-size: 1.18rem;
        font-weight: 400;
        line-height: 1.3;
        margin-bottom: 4px;
        word-break: break-word;
    }
    .serp-snippet {
        color: #4d5156;
        font-size: 0.88rem;
        line-height: 1.5;
        word-break: break-word;
    }

    /* Yoast-style Checklist Grouping */
    .seo-group-title {
        font-size: 0.82rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 16px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .seo-group-title.passed { color: #00a859; }
    .seo-group-title.warning { color: #ff9800; }
    .seo-group-title.failed { color: #f44336; }

    .seo-check-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 14px;
        margin-bottom: 10px;
        font-size: 0.85rem;
        transition: all 0.2s ease;
    }
    .seo-check-item.item-passed {
        border-left: 4px solid #00a859;
    }
    .seo-check-item.item-warning {
        border-left: 4px solid #ff9800;
    }
    .seo-check-item.item-failed {
        border-left: 4px solid #f44336;
    }
    .seo-check-header {
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 4px;
        color: #1e293b;
    }
    .seo-check-exp {
        color: #475569;
        margin-bottom: 4px;
        line-height: 1.45;
    }
    .seo-check-rec {
        font-size: 0.8rem;
        color: #0191b3;
        font-weight: 600;
    }

    /* Responsive grid */
    @media (max-width: 1024px) {
        .editor-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endpush

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('admin.news.index') }}" style="color: #64748b; text-decoration: none; font-size: 0.9rem; font-weight: 600;">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Berita
    </a>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px; flex-wrap: wrap; gap: 12px;">
        <h1 style="font-size: 1.8rem; font-weight: 800; color: #1e293b; margin: 0;">
            {{ isset($news) ? 'Edit Berita & Analisis SEO' : 'Tambah Berita Baru (CMS MBE)' }}
        </h1>
        <div style="font-size: 0.85rem; color: #64748b;">
            <i class="fa-solid fa-shield-halved text-success"></i> Sistem Analisis SEO Yoast-Style Aktif
        </div>
    </div>
</div>

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
    <div class="d-flex align-items-center gap-2 mb-2">
        <i class="fa-solid fa-triangle-exclamation fs-5"></i>
        <strong>Periksa kembali formulir:</strong>
    </div>
    <ul class="mb-0 ps-3">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<form action="{{ isset($news) ? route('admin.news.update', $news->id) : route('admin.news.store') }}" method="POST" enctype="multipart/form-data" id="newsForm">
    @csrf
    @if(isset($news))
        @method('PUT')
    @endif

    <div class="editor-grid" style="display: grid; grid-template-columns: 2.1fr 1.3fr; gap: 24px; align-items: start;">
        
        <!-- LEFT COLUMN: MAIN CONTENT & SEO CONFIGURATION -->
        <div>
            
            <!-- SECTION 1: KONTEN UTAMA -->
            <div class="card-editor">
                <div class="d-flex justify-content-between align-items-center pb-2 mb-3 border-bottom">
                    <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0;">
                        <i class="fa-solid fa-pen-nib text-primary"></i> Konten Artikel Berita
                    </h3>
                    <span class="badge bg-light text-secondary border">Wajib Diisi</span>
                </div>

                <!-- JUDUL -->
                <div class="mb-3">
                    <label class="form-label" for="title">
                        <span>JUDUL BERITA *</span>
                        <span id="titleCounter" class="char-counter">0 / 65</span>
                    </label>
                    <input type="text" name="title" id="title" class="form-control-custom" value="{{ old('title', $news->title ?? '') }}" required placeholder="Contoh: PT MBE Tambah Mesin CNC Presisi Baru untuk Dukung Manufaktur 2026">
                </div>

                <!-- SLUG URL -->
                <div class="mb-3">
                    <label class="form-label" for="slug">
                        <span>URL SLUG *</span>
                        <span style="font-size: 0.78rem; font-weight: normal; color: #64748b;">Dapat disesuaikan untuk SEO</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0" style="font-size: 0.85rem;">
                            makben.co.id/berita/
                        </span>
                        <input type="text" name="slug" id="slug" class="form-control-custom" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" value="{{ old('slug', $news->slug ?? '') }}" placeholder="pt-mbe-tambah-mesin-cnc-presisi-baru">
                    </div>
                </div>

                <!-- TANGGAL & HEADLINE OPTION -->
                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <label class="form-label" for="published_at">TANGGAL PUBLIKASI *</label>
                        <input type="date" name="published_at" id="published_at" class="form-control-custom" value="{{ old('published_at', isset($news->published_at) ? $news->published_at->format('Y-m-d') : date('Y-m-d')) }}" required>
                    </div>
                    <div class="col-sm-6 d-flex align-items-end">
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 10px 14px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; width: 100%; font-weight: 600; color: #0191b3;">
                            <input type="checkbox" name="is_headline" value="1" {{ old('is_headline', $news->is_headline ?? false) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #0191b3;">
                            <span><i class="fa-solid fa-star"></i> Headline Utama Beranda</span>
                        </label>
                    </div>
                </div>

                <!-- FEATURED IMAGE & ALT TEXT -->
                <div class="p-3 bg-light rounded-3 border mb-3">
                    <label class="form-label" for="image">
                        <span>GAMBAR UTAMA (FEATURED IMAGE)</span>
                        <span style="font-size: 0.8rem; font-weight: normal; color: #0191b3;">Rekomendasi 16:9 (1200x675 px)</span>
                    </label>
                    <input type="file" name="image" id="image" class="form-control-custom" accept="image/*" onchange="previewFeaturedImage(this)">
                    
                    <div id="imagePreviewContainer" style="margin-top: 12px; {{ isset($news) && $news->image ? '' : 'display:none;' }}">
                        <img id="imagePreview" src="{{ isset($news) && $news->image ? asset($news->image) : '' }}" style="max-height: 180px; max-width: 100%; border-radius: 8px; border: 1px solid #cbd5e1; object-fit: cover;">
                    </div>

                    <!-- ALT TEXT -->
                    <div class="mt-3">
                        <label class="form-label" for="image_alt">
                            <span>ALT TEXT GAMBAR (TEKS ALTERNATIF) *</span>
                            <span class="char-counter" id="altCounter">Wajib untuk SEO Gambar</span>
                        </label>
                        <input type="text" name="image_alt" id="image_alt" class="form-control-custom" value="{{ old('image_alt', $news->image_alt ?? '') }}" placeholder="Deskripsikan isi foto, contoh: Teknisi PT MBE mengoperasikan mesin bubut CNC presisi di workshop Cirebon">
                        <small class="text-muted d-block mt-1" style="font-size: 0.78rem;">
                            <i class="fa-solid fa-circle-info"></i> Teks alternatif dibaca oleh Google Image Search dan pembaca tunanetra untuk memahami gambar.
                        </small>
                    </div>
                </div>

                <!-- RINGKASAN EXCERPT -->
                <div class="mb-3">
                    <label class="form-label" for="excerpt">
                        <span>RINGKASAN SINGKAT (EXCERPT)</span>
                        <span class="char-counter" id="excerptCounter">0 / 200</span>
                    </label>
                    <textarea name="excerpt" id="excerpt" class="form-control-custom" style="min-height: 75px;" placeholder="Tuliskan ringkasan 1-2 kalimat untuk kartu berita di beranda...">{{ old('excerpt', $news->excerpt ?? '') }}</textarea>
                </div>

                <!-- ISI KONTEN LENGKAP -->
                <div class="mb-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label m-0" for="content">ISI BERITA LENGKAP *</label>
                        <span style="font-size: 0.82rem; font-weight: 700; color: #0191b3;" id="contentStats">
                            <i class="fa-solid fa-file-lines"></i> 0 kata | ~0 mnt baca
                        </span>
                    </div>

                    <!-- QUICK TOOLBAR: SISIPKAN GAMBAR & FORMAT SEPERTI DI CONTOH -->
                    <div class="d-flex flex-wrap gap-2 p-2 bg-light border border-bottom-0 rounded-top align-items-center">
                        <button type="button" class="btn btn-sm btn-primary fw-semibold d-inline-flex align-items-center gap-1 shadow-sm" data-bs-toggle="modal" data-bs-target="#insertImageModal" style="font-size: 0.82rem;">
                            <i class="fa-solid fa-image"></i> Sisipkan Gambar + Sumber
                        </button>
                        <button type="button" class="btn btn-sm btn-light border bg-white text-dark fw-semibold" onclick="insertHeading('h3')" style="font-size: 0.82rem;" title="Sisipkan sub-heading H3">
                            <i class="fa-solid fa-heading"></i> Sub-Judul H3
                        </button>
                        <button type="button" class="btn btn-sm btn-light border bg-white text-dark fw-semibold" onclick="insertHeading('h2')" style="font-size: 0.82rem;" title="Sisipkan sub-heading H2">
                            <i class="fa-solid fa-heading"></i> Sub-Judul H2
                        </button>
                        <button type="button" class="btn btn-sm btn-light border bg-white text-dark fw-semibold" onclick="insertLinkPrompt()" style="font-size: 0.82rem;" title="Sisipkan link tautan">
                            <i class="fa-solid fa-link"></i> Tautan / Link
                        </button>
                        <span class="text-muted ms-auto small d-none d-md-inline" style="font-size: 0.76rem;">
                            <i class="fa-solid fa-wand-magic-sparkles text-warning"></i> Format otomatis langsung terpasang
                        </span>
                    </div>

                    <textarea name="content" id="content" class="form-control-custom" style="min-height: 320px; line-height: 1.6; border-top-left-radius: 0; border-top-right-radius: 0;" required placeholder="Tuliskan isi artikel lengkap di sini...">{{ old('content', $news->content ?? '') }}</textarea>
                    <small class="text-muted d-block mt-1" style="font-size: 0.8rem;">
                        <i class="fa-solid fa-lightbulb text-warning"></i> <strong>Tips:</strong> Klik tombol <strong>"Sisipkan Gambar + Sumber"</strong> di atas untuk memasukkan foto di tengah artikel lengkap dengan keterangan sumber seperti pada majalah atau portal berita.
                    </small>
                </div>
            </div>

            <!-- SECTION 2: YOAST-STYLE SEO METADATA CONFIGURATION -->
            <div class="card-editor">
                <div class="d-flex justify-content-between align-items-center pb-2 mb-3 border-bottom">
                    <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0;">
                        <i class="fa-solid fa-magnifying-glass-chart" style="color: #0191b3;"></i> Konfigurasi Metadata Google & SEO
                    </h3>
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">Google Search Snippet</span>
                </div>

                <!-- FOCUS KEYWORD -->
                <div class="mb-3 p-3 bg-light rounded-3 border">
                    <label class="form-label" for="focus_keyword">
                        <span class="fw-bold text-dark"><i class="fa-solid fa-key text-warning"></i> FOCUS KEYWORD (KATA KUNCI UTAMA)</span>
                        <span class="badge bg-secondary" id="kwDensityBadge">Kepadatan: 0%</span>
                    </label>
                    <input type="text" name="focus_keyword" id="focus_keyword" class="form-control-custom" value="{{ old('focus_keyword', $news->focus_keyword ?? '') }}" placeholder="Contoh: Fabrikasi Cirebon, Machining CNC, Bending Plat">
                    <small class="text-muted d-block mt-1" style="font-size: 0.8rem;">
                        Kata kunci utama yang ingin ditargetkan agar artikel ini mudah ditemukan di Google.
                    </small>
                </div>

                <!-- META TITLE -->
                <div class="mb-3">
                    <label class="form-label" for="meta_title">
                        <span>SEO / META TITLE</span>
                        <span id="metaTitleCounter" class="char-counter">0 / 60</span>
                    </label>
                    <input type="text" name="meta_title" id="meta_title" class="form-control-custom" value="{{ old('meta_title', $news->meta_title ?? '') }}" placeholder="Kosongkan jika ingin menyamakan dengan judul artikel di atas">
                    <div class="progress mt-1" style="height: 4px;">
                        <div id="metaTitleProgress" class="progress-bar bg-danger" style="width: 0%"></div>
                    </div>
                </div>

                <!-- META DESCRIPTION -->
                <div class="mb-3">
                    <label class="form-label" for="meta_description">
                        <span>META DESCRIPTION</span>
                        <span id="metaDescCounter" class="char-counter">0 / 160</span>
                    </label>
                    <textarea name="meta_description" id="meta_description" class="form-control-custom" style="min-height: 85px;" placeholder="Deskripsi ringkas yang tampil di hasil pencarian Google (idealnya 120-160 karakter)...">{{ old('meta_description', $news->meta_description ?? '') }}</textarea>
                    <div class="progress mt-1" style="height: 4px;">
                        <div id="metaDescProgress" class="progress-bar bg-danger" style="width: 0%"></div>
                    </div>
                </div>

                <!-- GOOGLE SERP PREVIEW BOX -->
                <div class="mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label m-0 text-muted" style="font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            <i class="fa-brands fa-google text-primary"></i> Pratinjau Tampilan di Google (SERP Preview)
                        </label>
                        <span class="badge bg-light text-muted border" style="font-size: 0.72rem;">Pratinjau Hasil Pencarian</span>
                    </div>

                    <div class="serp-preview-box">
                        <div class="serp-source">
                            <img src="{{ asset('assets/images/page_beranda/logo makben.png') }}" alt="MBE Favicon">
                            <div>
                                <div style="font-weight: 500; font-size: 0.84rem; line-height: 1;">PT Makmur Bersama Enjiniring</div>
                                <div class="serp-breadcrumb" id="serpUrl">https://makben.co.id › berita › {{ $news->slug ?? 'judul-berita' }}</div>
                            </div>
                        </div>
                        <div class="serp-title" id="serpTitle">
                            {{ $news->meta_title ?? $news->title ?? 'Judul Berita Artikel Anda - PT Makmur Bersama Enjiniring' }}
                        </div>
                        <div class="serp-snippet" id="serpSnippet">
                            {{ $news->meta_description ?? 'Tuliskan deskripsi meta yang menarik agar calon pelanggan mengklik tautan Anda saat mencari layanan manufaktur atau fabrikasi...' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="d-flex gap-3 align-items-center mb-4">
                <button type="submit" class="btn btn-mbe py-3 px-4 fs-6 shadow-sm">
                    <i class="fa-solid fa-floppy-disk me-2"></i> {{ isset($news) ? 'Simpan Perubahan Berita' : 'Terbitkan Berita Sekarang' }}
                </button>
                <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary py-3 px-4">
                    Batal
                </a>
            </div>
        </div>

        <!-- RIGHT COLUMN: YOAST-STYLE LIVE SEO SCORE EVALUATOR -->
        <div>
            <div class="card-editor" style="position: sticky; top: 85px; z-index: 10;">
                <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom">
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0;">
                        <i class="fa-solid fa-gauge-high text-primary me-1"></i> Skor Analisis SEO
                    </h3>
                    <span id="syncIndicator" class="badge bg-light text-muted border" style="font-size: 0.72rem;">
                        <i class="fa-solid fa-bolt text-warning"></i> Real-time
                    </span>
                </div>

                <!-- LIVE SCORE CIRCULAR GAUGE -->
                <div style="text-align: center; padding: 10px 0 16px; border-bottom: 1px solid #e2e8f0;">
                    <div id="seoGauge" style="width: 120px; height: 120px; border-radius: 50%; background: conic-gradient(#f44336 0deg, #edf2f7 0deg); display: flex; align-items: center; justify-content: center; margin: 0 auto; transition: all 0.5s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
                        <div style="width: 92px; height: 92px; background: #ffffff; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                            <span id="seoScoreText" style="font-size: 2rem; font-weight: 800; color: #f44336; line-height: 1;">0%</span>
                            <span style="font-size: 0.68rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">SEO SCORE</span>
                        </div>
                    </div>
                    <div id="seoStatusBadge" style="margin-top: 12px; font-weight: 800; font-size: 0.95rem; color: #f44336;">
                        Kurang (Poor SEO)
                    </div>
                    <div id="seoIncompleteNotice" class="text-muted mt-1" style="font-size: 0.78rem; display: none;">
                        <i class="fa-solid fa-circle-exclamation text-secondary"></i> Focus keyword belum diisi, analisis belum lengkap.
                    </div>
                </div>

                <!-- ACCORDION / GROUPED CHECKLIST (PASSED, WARNINGS, FAILED) -->
                <div style="max-height: calc(100vh - 360px); overflow-y: auto; padding-right: 4px; margin-top: 14px;">
                    
                    <!-- FAILED / ERRORS GROUP -->
                    <div id="groupFailedContainer">
                        <div class="seo-group-title failed">
                            <i class="fa-solid fa-circle-xmark"></i> Perlu Dibenahi (<span id="countFailed">0</span>)
                        </div>
                        <div id="listFailed"></div>
                    </div>

                    <!-- WARNINGS GROUP -->
                    <div id="groupWarningContainer">
                        <div class="seo-group-title warning">
                            <i class="fa-solid fa-triangle-exclamation"></i> Perlu Peningkatan (<span id="countWarning">0</span>)
                        </div>
                        <div id="listWarning"></div>
                    </div>

                    <!-- PASSED GROUP -->
                    <div id="groupPassedContainer">
                        <div class="seo-group-title passed">
                            <i class="fa-solid fa-circle-check"></i> Lolos Analisis (<span id="countPassed">0</span>)
                        </div>
                        <div id="listPassed"></div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</form>

<!-- MODAL SISIPKAN GAMBAR KE ISI BERITA LENGKAP -->
<div class="modal fade" id="insertImageModal" tabindex="-1" aria-labelledby="insertImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold" id="insertImageModalLabel" style="font-size: 1.05rem;">
                    <i class="fa-solid fa-image text-primary me-2"></i> Sisipkan Gambar ke Isi Berita
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <ul class="nav nav-pills nav-fill mb-3" id="imageInsertTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active py-2" id="upload-tab" data-bs-toggle="pill" data-bs-target="#tab-upload" type="button" role="tab">
                            <i class="fa-solid fa-cloud-arrow-up me-1"></i> Upload dari Komputer
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link py-2" id="url-tab" data-bs-toggle="pill" data-bs-target="#tab-url" type="button" role="tab">
                            <i class="fa-solid fa-link me-1"></i> Gunakan URL / Path
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="imageInsertTabContent">
                    <!-- TAB 1: UPLOAD -->
                    <div class="tab-pane fade show active" id="tab-upload" role="tabpanel">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Pilih Berkas Foto / Gambar *</label>
                            <input type="file" id="inlineImageFile" class="form-control" accept="image/*">
                            <div class="text-muted mt-1" style="font-size: 0.75rem;">Format: JPG, PNG, WEBP. Maksimal 5MB. Otomatis disimpan ke server.</div>
                        </div>
                    </div>

                    <!-- TAB 2: URL -->
                    <div class="tab-pane fade" id="tab-url" role="tabpanel">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">URL Gambar atau Path *</label>
                            <input type="text" id="inlineImageUrl" class="form-control" placeholder="Contoh: /assets/images/news/foto.jpg atau https://...">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Deskripsi Gambar (Alt Text) *</label>
                    <input type="text" id="inlineImageAlt" class="form-control" placeholder="Contoh: Pemasangan Batu Ocean Wave di area taman">
                </div>

                <div class="mb-2">
                    <label class="form-label fw-bold small">Keterangan Sumber / Caption (Opsional)</label>
                    <input type="text" id="inlineImageCaption" class="form-control" placeholder="Contoh: Sumber : Stone Depot">
                    <div class="text-muted mt-1" style="font-size: 0.75rem;">Tampil persis di bawah gambar seperti pada contoh artikel media/majalah.</div>
                </div>

                <div id="inlineUploadLoading" class="alert alert-info py-2 small d-none mt-3">
                    <i class="fa-solid fa-spinner fa-spin me-2"></i> Sedang mengunggah gambar, mohon tunggu...
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary px-4 fw-semibold" id="btnConfirmInsertImage" onclick="handleInsertInlineImage()">
                    <i class="fa-solid fa-check me-1"></i> Sisipkan ke Artikel
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Token and Endpoint for Server Verification
const CSRF_TOKEN = '{{ csrf_token() }}';
const ANALYZE_ENDPOINT = '{{ route("admin.news.analyze-seo") }}';
const INLINE_UPLOAD_ENDPOINT = '{{ route("admin.news.upload-inline-image") }}';

// State & Cache
let debounceTimer = null;

function insertHeading(tag) {
    const textarea = document.getElementById('content');
    const selectedText = textarea.value.substring(textarea.selectionStart, textarea.selectionEnd) || (tag === 'h3' ? 'Sub-Judul Bagian Artikel' : 'Topik Pembahasan Utama');
    const template = `\n\n<${tag}>${selectedText}</${tag}>\n\n`;
    insertTextAtCursor(textarea, template);
    runSeoAnalysis();
}

function insertLinkPrompt() {
    const url = prompt('Masukkan URL tautan (contoh: /layanan atau /produk):', '/layanan');
    if (!url) return;
    const text = prompt('Teks tautan yang ditampilkan kepada pembaca:', 'Layanan Kami');
    if (!text) return;
    const textarea = document.getElementById('content');
    const template = `<a href="${url}">${text}</a>`;
    insertTextAtCursor(textarea, template);
    runSeoAnalysis();
}

function insertTextAtCursor(textarea, text) {
    const startPos = textarea.selectionStart;
    const endPos = textarea.selectionEnd;
    const before = textarea.value.substring(0, startPos);
    const after = textarea.value.substring(endPos, textarea.value.length);
    textarea.value = before + text + after;
    textarea.selectionStart = textarea.selectionEnd = startPos + text.length;
    textarea.focus();
}

function handleInsertInlineImage() {
    const activeTab = document.querySelector('#imageInsertTab .nav-link.active').id;
    const alt = document.getElementById('inlineImageAlt').value.trim();
    const caption = document.getElementById('inlineImageCaption').value.trim();
    const loading = document.getElementById('inlineUploadLoading');
    const btn = document.getElementById('btnConfirmInsertImage');

    if (activeTab === 'upload-tab') {
        const fileInput = document.getElementById('inlineImageFile');
        if (!fileInput.files || !fileInput.files[0]) {
            alert('Silakan pilih berkas foto / gambar terlebih dahulu.');
            return;
        }

        const formData = new FormData();
        formData.append('image', fileInput.files[0]);
        formData.append('alt', alt);
        formData.append('caption', caption);
        formData.append('_token', CSRF_TOKEN);

        loading.classList.remove('d-none');
        btn.disabled = true;

        fetch(INLINE_UPLOAD_ENDPOINT, {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            loading.classList.add('d-none');
            btn.disabled = false;
            if (data.success) {
                appendFigureToContent(data.url, data.alt, data.caption);
                const modalEl = document.getElementById('insertImageModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
                fileInput.value = '';
                document.getElementById('inlineImageAlt').value = '';
                document.getElementById('inlineImageCaption').value = '';
            } else {
                alert('Gagal mengunggah: ' + (data.message || 'Terjadi kesalahan.'));
            }
        })
        .catch(err => {
            loading.classList.add('d-none');
            btn.disabled = false;
            alert('Gagal mengunggah gambar. Pastikan format gambar JPG/PNG/WEBP dan ukuran max 5MB.');
        });
    } else {
        const url = document.getElementById('inlineImageUrl').value.trim();
        if (!url) {
            alert('Silakan masukkan URL atau path gambar.');
            return;
        }
        appendFigureToContent(url, alt, caption);
        const modalEl = document.getElementById('insertImageModal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        document.getElementById('inlineImageUrl').value = '';
        document.getElementById('inlineImageAlt').value = '';
        document.getElementById('inlineImageCaption').value = '';
    }
}

function appendFigureToContent(url, alt, caption) {
    const textarea = document.getElementById('content');
    const safeAlt = alt || 'Dokumentasi Artikel PT MBE';
    const captionHtml = caption ? `\n    <figcaption style="font-size: 0.88rem; color: #64748b; margin-top: 8px; font-weight: 500;">${caption}</figcaption>` : '';
    
    const figureHtml = `\n\n<figure style="margin: 28px 0; text-align: left;">\n    <img src="${url}" alt="${safeAlt}" style="width: 100%; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.06); object-fit: cover;">${captionHtml}\n</figure>\n\n`;

    insertTextAtCursor(textarea, figureHtml);
    runSeoAnalysis();
}

function previewFeaturedImage(input) {
    const preview = document.getElementById('imagePreview');
    const container = document.getElementById('imagePreviewContainer');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.style.display = 'block';
            runSeoAnalysis();
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Strip HTML tags and entities
function cleanHtml(html) {
    if (!html) return '';
    return html.replace(/<script[^>]*>([\S\s]*?)<\/script>/gmi, '')
               .replace(/<style[^>]*>([\S\s]*?)<\/style>/gmi, '')
               .replace(/<[^>]+>/gm, ' ')
               .replace(/&nbsp;/g, ' ')
               .replace(/\s+/g, ' ')
               .trim();
}

// Count Unicode words
function countWords(str) {
    if (!str || !str.trim()) return 0;
    const matches = str.trim().match(/[\p{L}\p{N}]+/gu);
    return matches ? matches.length : 0;
}

// Convert text to slug
function slugify(text) {
    return text.toString().toLowerCase()
        .trim()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\-\-+/g, '-')
        .replace(/^-+/, '')
        .replace(/-+$/, '');
}

// Full Local Yoast-Style SEO Evaluator Engine
function evaluateSeoLocal() {
    const title = document.getElementById('title').value.trim();
    const metaTitle = document.getElementById('meta_title').value.trim();
    const effectiveTitle = metaTitle || title;
    const focusKeyword = document.getElementById('focus_keyword').value.trim().toLowerCase();
    const metaDesc = document.getElementById('meta_description').value.trim();
    const rawContent = document.getElementById('content').value;
    const cleanContent = cleanHtml(rawContent);
    const words = countWords(cleanContent);
    const rawSlug = document.getElementById('slug').value.trim();
    const slug = rawSlug || slugify(title);
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const hasImage = (imageInput && imageInput.files.length > 0) || (imagePreview && imagePreview.src && imagePreview.src.length > 10 && !imagePreview.src.endsWith('/'));
    const imageAlt = document.getElementById('image_alt').value.trim();

    // Update Field Counters & Progress Bars
    updateCounters(title, metaTitle, metaDesc, cleanContent, words, focusKeyword);

    // Update Google SERP Preview
    updateSerpPreview(effectiveTitle, slug, metaDesc, cleanContent);

    // 10 SEO Checkpoints
    const checks = [];

    // 1. Title Length Check (35-65 chars) - 10 pts
    const titleLen = effectiveTitle.length;
    if (titleLen >= 35 && titleLen <= 65) {
        checks.push({
            id: 'title_length',
            label: 'Panjang SEO Title',
            status: 'passed',
            score: 10,
            exp: `Panjang judul SEO ideal (${titleLen} karakter). Tampil proporsional di Google tanpa terpotong.`,
            rec: 'Pertahankan panjang judul pada 35–65 karakter.'
        });
    } else if ((titleLen >= 20 && titleLen < 35) || (titleLen > 65 && titleLen <= 75)) {
        checks.push({
            id: 'title_length',
            label: 'Panjang SEO Title',
            status: 'warning',
            score: 5,
            exp: `Panjang judul SEO ${titleLen} karakter. Disarankan antara 35–65 karakter agar tidak terpotong.`,
            rec: 'Sesuaikan panjang judul menjadi 35–65 karakter.'
        });
    } else {
        checks.push({
            id: 'title_length',
            label: 'Panjang SEO Title',
            status: 'failed',
            score: 0,
            exp: titleLen === 0 ? 'Judul artikel belum diisi.' : `Panjang judul SEO (${titleLen} karakter) belum optimal.`,
            rec: 'Tulis judul yang menarik sepanjang 35–65 karakter.'
        });
    }

    // 2. Focus Keyword in Title - 10 pts
    if (!focusKeyword) {
        checks.push({
            id: 'keyword_in_title',
            label: 'Kata Kunci di SEO Title',
            status: 'failed',
            score: 0,
            exp: 'Focus keyword belum ditentukan.',
            rec: 'Tentukan kata kunci fokus artikel Anda.'
        });
    } else if (effectiveTitle.toLowerCase().includes(focusKeyword)) {
        checks.push({
            id: 'keyword_in_title',
            label: 'Kata Kunci di SEO Title',
            status: 'passed',
            score: 10,
            exp: `Focus keyword "${focusKeyword}" ditemukan di dalam judul.`,
            rec: 'Bagus! Kata kunci berada di judul utama.'
        });
    } else {
        checks.push({
            id: 'keyword_in_title',
            label: 'Kata Kunci di SEO Title',
            status: 'failed',
            score: 0,
            exp: `Focus keyword "${focusKeyword}" tidak ditemukan di dalam judul SEO.`,
            rec: `Sisipkan kata kunci "${focusKeyword}" pada judul atau Meta Title.`
        });
    }

    // 3. Meta Description Length Check (110-165 chars) - 10 pts
    const descLen = metaDesc.length;
    if (descLen >= 110 && descLen <= 165) {
        checks.push({
            id: 'meta_description_length',
            label: 'Panjang Meta Description',
            status: 'passed',
            score: 10,
            exp: `Panjang deskripsi meta sangat baik (${descLen} karakter).`,
            rec: 'Deskripsi meta siap memikat pengunjung di hasil pencarian.'
        });
    } else if ((descLen >= 70 && descLen < 110) || (descLen > 165 && descLen <= 190)) {
        checks.push({
            id: 'meta_description_length',
            label: 'Panjang Meta Description',
            status: 'warning',
            score: 5,
            exp: `Panjang deskripsi meta ${descLen} karakter. Idealnya adalah 110–165 karakter.`,
            rec: 'Optimalkan panjang deskripsi antara 110 hingga 165 karakter.'
        });
    } else {
        checks.push({
            id: 'meta_description_length',
            label: 'Panjang Meta Description',
            status: 'failed',
            score: 0,
            exp: descLen === 0 ? 'Meta description belum diisi.' : `Panjang meta description (${descLen} karakter) belum memenuhi standar.`,
            rec: 'Tulis ringkasan informatif sepanjang 110–165 karakter.'
        });
    }

    // 4. Focus Keyword in Slug - 10 pts
    const kwSlug = slugify(focusKeyword);
    const checkSlug = slugify(slug);
    if (!focusKeyword) {
        checks.push({
            id: 'keyword_in_slug',
            label: 'Kata Kunci di URL Slug',
            status: 'failed',
            score: 0,
            exp: 'Focus keyword belum ditentukan.',
            rec: 'Tentukan kata kunci fokus terlebih dahulu.'
        });
    } else if (kwSlug && checkSlug.includes(kwSlug)) {
        checks.push({
            id: 'keyword_in_slug',
            label: 'Kata Kunci di URL Slug',
            status: 'passed',
            score: 10,
            exp: `URL slug memuat kata kunci fokus (${slug}).`,
            rec: 'Struktur URL ramah SEO dan mudah diingat.'
        });
    } else {
        checks.push({
            id: 'keyword_in_slug',
            label: 'Kata Kunci di URL Slug',
            status: 'failed',
            score: 0,
            exp: `URL slug tidak memuat kata kunci fokus "${focusKeyword}".`,
            rec: `Perbarui URL slug agar mengandung kata kunci (contoh: ${kwSlug || 'kata-kunci'}).`
        });
    }

    // 5. Content Length (>= 300 words) - 10 pts
    if (words >= 300) {
        checks.push({
            id: 'content_length',
            label: 'Panjang Teks Artikel',
            status: 'passed',
            score: 10,
            exp: `Artikel memiliki kedalaman teks yang memuaskan (${words} kata).`,
            rec: 'Panjang artikel sudah di atas target minimal 300 kata.'
        });
    } else if (words >= 150) {
        checks.push({
            id: 'content_length',
            label: 'Panjang Teks Artikel',
            status: 'warning',
            score: 5,
            exp: `Artikel memiliki ${words} kata. Disarankan minimal 300 kata untuk ulasan yang mendalam.`,
            rec: 'Tambahkan detail teknis atau pembahasan lebih lanjut hingga 300 kata.'
        });
    } else {
        checks.push({
            id: 'content_length',
            label: 'Panjang Teks Artikel',
            status: 'failed',
            score: 0,
            exp: words === 0 ? 'Konten artikel masih kosong.' : `Konten terlalu pendek (${words} kata).`,
            rec: 'Tulis isi artikel dengan minimal 150–300 kata.'
        });
    }

    // 6. Keyword in Opening Paragraph - 10 pts
    let firstParagraph = '';
    const pMatch = rawContent.match(/<p[^>]*>(.*?)<\/p>/i);
    if (pMatch && pMatch[1]) {
        firstParagraph = cleanHtml(pMatch[1]).toLowerCase();
    } else {
        firstParagraph = cleanContent.toLowerCase().split(/\s+/).slice(0, 80).join(' ');
    }

    if (!focusKeyword) {
        checks.push({
            id: 'keyword_in_first_paragraph',
            label: 'Kata Kunci di Paragraf Pembuka',
            status: 'failed',
            score: 0,
            exp: 'Focus keyword belum ditentukan.',
            rec: 'Tentukan kata kunci fokus terlebih dahulu.'
        });
    } else if (firstParagraph.includes(focusKeyword)) {
        checks.push({
            id: 'keyword_in_first_paragraph',
            label: 'Kata Kunci di Paragraf Pembuka',
            status: 'passed',
            score: 10,
            exp: `Focus keyword "${focusKeyword}" hadir pada paragraf pembuka artikel.`,
            rec: 'Pembaca dan bot pencari langsung mengenali topik utama sejak awal.'
        });
    } else {
        checks.push({
            id: 'keyword_in_first_paragraph',
            label: 'Kata Kunci di Paragraf Pembuka',
            status: 'failed',
            score: 0,
            exp: `Focus keyword "${focusKeyword}" tidak ditemukan di paragraf awal artikel.`,
            rec: `Sebutkan kata kunci "${focusKeyword}" pada kalimat pertama atau kedua pembuka.`
        });
    }

    // 7. Heading Structure (H2 or H3 present) - 10 pts
    const headingMatches = rawContent.match(/<h([2-3])[^>]*>(.*?)<\/h\1>/gi);
    if (headingMatches && headingMatches.length > 0) {
        let kwInHeading = false;
        if (focusKeyword) {
            headingMatches.forEach(h => {
                if (cleanHtml(h).toLowerCase().includes(focusKeyword)) {
                    kwInHeading = true;
                }
            });
        }

        if (kwInHeading) {
            checks.push({
                id: 'heading_structure',
                label: 'Struktur Heading (H2/H3)',
                status: 'passed',
                score: 10,
                exp: `Artikel memiliki ${headingMatches.length} sub-heading dan memuat kata kunci fokus.`,
                rec: 'Struktur heading sangat baik.'
            });
        } else {
            checks.push({
                id: 'heading_structure',
                label: 'Struktur Heading (H2/H3)',
                status: 'passed',
                score: 8,
                exp: `Ditemukan ${headingMatches.length} sub-heading. Sisipkan kata kunci pada salah satu sub-heading untuk optimasi penuh.`,
                rec: 'Sertakan kata kunci pada sub-heading H2.'
            });
        }
    } else {
        checks.push({
            id: 'heading_structure',
            label: 'Struktur Heading (H2/H3)',
            status: 'failed',
            score: 0,
            exp: 'Belum ada sub-heading (H2 atau H3) di dalam artikel.',
            rec: 'Gunakan tag <h2> atau <h3> untuk menstrukturkan artikel menjadi beberapa poin bacaan.'
        });
    }

    // 8. Featured Image & Alt Text - 10 pts
    if (hasImage && imageAlt.length >= 5) {
        checks.push({
            id: 'featured_image',
            label: 'Gambar Utama & Alt Text',
            status: 'passed',
            score: 10,
            exp: `Gambar utama tersedia dan dilengkapi Alt Text yang jelas ("${imageAlt}").`,
            rec: 'Alt text gambar sudah informatif untuk Google Image Search.'
        });
    } else if (hasImage && imageAlt.length < 5) {
        checks.push({
            id: 'featured_image',
            label: 'Gambar Utama & Alt Text',
            status: 'warning',
            score: 5,
            exp: 'Gambar utama sudah diunggah, namun Teks Alternatif (Alt Text) masih kosong atau terlalu pendek.',
            rec: 'Isi kolom Alt Text Gambar untuk membantu peringkat gambar di Google.'
        });
    } else {
        checks.push({
            id: 'featured_image',
            label: 'Gambar Utama & Alt Text',
            status: 'failed',
            score: 0,
            exp: 'Artikel belum memiliki gambar utama (featured image).',
            rec: 'Unggah gambar utama berformat landscape (16:9) dan berikan alt text deskriptif.'
        });
    }

    // 9. Internal Links in Content - 10 pts
    const linkMatches = rawContent.match(/<a\s+[^>]*href=["']([^"']+)["']/gi);
    if (linkMatches && linkMatches.length > 0) {
        let hasInternal = false;
        linkMatches.forEach(linkTag => {
            const hrefMatch = linkTag.match(/href=["']([^"']+)["']/i);
            if (hrefMatch && hrefMatch[1]) {
                const href = hrefMatch[1].trim();
                if (href.startsWith('/') || href.startsWith('#') || href.includes('makben.co.id') || href.includes('localhost') || (!href.startsWith('http://') && !href.startsWith('https://'))) {
                    hasInternal = true;
                }
            }
        });

        if (hasInternal) {
            checks.push({
                id: 'internal_links',
                label: 'Tautan Internal (Internal Links)',
                status: 'passed',
                score: 10,
                exp: 'Ditemukan tautan internal yang memperkuat navigasi situs.',
                rec: 'Tautan internal artikel sudah baik.'
            });
        } else {
            checks.push({
                id: 'internal_links',
                label: 'Tautan Internal (Internal Links)',
                status: 'warning',
                score: 5,
                exp: 'Terdapat tautan, namun seluruhnya mengarah ke domain eksternal.',
                rec: 'Tambahkan tautan internal yang mengarahkan pembaca ke layanan atau produk PT MBE.'
            });
        }
    } else {
        checks.push({
            id: 'internal_links',
            label: 'Tautan Internal (Internal Links)',
            status: 'failed',
            score: 0,
            exp: 'Tidak ada tautan internal di dalam teks artikel.',
            rec: 'Tambahkan setidaknya satu tautan ke halaman produk atau layanan terkait (contoh: <a href="/layanan">Layanan Kami</a>).'
        });
    }

    // 10. Keyword Density & Natural Usage (0.5% - 3.0%) - 10 pts
    if (!focusKeyword) {
        checks.push({
            id: 'keyword_density',
            label: 'Kepadatan Kata Kunci (Density)',
            status: 'failed',
            score: 0,
            exp: 'Focus keyword belum ditentukan.',
            rec: 'Tentukan kata kunci fokus terlebih dahulu.'
        });
    } else if (words === 0) {
        checks.push({
            id: 'keyword_density',
            label: 'Kepadatan Kata Kunci (Density)',
            status: 'failed',
            score: 0,
            exp: 'Artikel kosong, tidak dapat menghitung kepadatan kata kunci.',
            rec: 'Tuliskan isi artikel terlebih dahulu.'
        });
    } else {
        // Count occurrences
        const lowerClean = cleanContent.toLowerCase();
        let occurrences = 0;
        let pos = lowerClean.indexOf(focusKeyword);
        while (pos !== -1) {
            occurrences++;
            pos = lowerClean.indexOf(focusKeyword, pos + focusKeyword.length);
        }

        const kwWordCount = Math.max(1, countWords(focusKeyword));
        const density = words > 0 ? ((occurrences * kwWordCount / words) * 100).toFixed(1) : 0;

        if (occurrences === 0) {
            checks.push({
                id: 'keyword_density',
                label: 'Kepadatan Kata Kunci (Density)',
                status: 'failed',
                score: 0,
                exp: `Kata kunci "${focusKeyword}" sama sekali belum muncul dalam teks artikel (0 kali).`,
                rec: `Gunakan kata kunci "${focusKeyword}" beberapa kali secara alami dalam teks.`
            });
        } else if (density > 3.0) {
            checks.push({
                id: 'keyword_density',
                label: 'Kepadatan Kata Kunci (Density)',
                status: 'warning',
                score: 3,
                exp: `Kepadatan kata kunci terlalu tinggi (${density}%, muncul ${occurrences} kali). Berpotensi keyword stuffing.`,
                rec: 'Kurangi pengulangan kata kunci agar artikel terbaca alami.'
            });
        } else if (density >= 0.5 && density <= 3.0) {
            checks.push({
                id: 'keyword_density',
                label: 'Kepadatan Kata Kunci (Density)',
                status: 'passed',
                score: 10,
                exp: `Kepadatan kata kunci sangat optimal (${density}%, muncul ${occurrences} kali dalam ${words} kata).`,
                rec: 'Penggunaan kata kunci seimbang dan natural.'
            });
        } else {
            checks.push({
                id: 'keyword_density',
                label: 'Kepadatan Kata Kunci (Density)',
                status: 'warning',
                score: 6,
                exp: `Kepadatan kata kunci agak rendah (${density}%, muncul ${occurrences} kali).`,
                rec: 'Sisipkan kata kunci 1–2 kali lagi pada paragraf yang sesuai.'
            });
        }
    }

    // Calculate Total Score
    let totalScore = 0;
    checks.forEach(c => totalScore += c.score);
    totalScore = Math.max(0, Math.min(100, Math.round(totalScore)));

    // Render Checklist UI
    renderChecklistUI(checks, totalScore, !!focusKeyword);
}

function updateCounters(title, metaTitle, metaDesc, content, words, focusKeyword) {
    // Title counter
    const tCount = document.getElementById('titleCounter');
    const tLen = (metaTitle || title).length;
    tCount.innerText = `${tLen} / 65`;
    tCount.className = `char-counter ${tLen >= 35 && tLen <= 65 ? 'good' : (tLen > 0 ? 'warning' : 'danger')}`;

    // Meta Title counter & progress bar
    const mtCount = document.getElementById('metaTitleCounter');
    const mtLen = metaTitle.length;
    mtCount.innerText = `${mtLen} / 60`;
    mtCount.className = `char-counter ${mtLen >= 35 && mtLen <= 60 ? 'good' : (mtLen > 0 ? 'warning' : '')}`;
    const mtProg = document.getElementById('metaTitleProgress');
    const mtPct = Math.min(100, (mtLen / 60) * 100);
    mtProg.style.width = mtPct + '%';
    mtProg.className = `progress-bar ${mtLen >= 35 && mtLen <= 60 ? 'bg-success' : (mtLen > 60 ? 'bg-danger' : 'bg-warning')}`;

    // Meta Description counter & progress bar
    const mdCount = document.getElementById('metaDescCounter');
    const mdLen = metaDesc.length;
    mdCount.innerText = `${mdLen} / 160`;
    mdCount.className = `char-counter ${mdLen >= 110 && mdLen <= 165 ? 'good' : (mdLen > 0 ? 'warning' : 'danger')}`;
    const mdProg = document.getElementById('metaDescProgress');
    const mdPct = Math.min(100, (mdLen / 160) * 100);
    mdProg.style.width = mdPct + '%';
    mdProg.className = `progress-bar ${mdLen >= 110 && mdLen <= 165 ? 'bg-success' : (mdLen > 165 ? 'bg-danger' : 'bg-warning')}`;

    // Content Stats
    const readingTime = Math.ceil(words / 200);
    document.getElementById('contentStats').innerHTML = `<i class="fa-solid fa-file-lines"></i> ${words} kata | ~${readingTime} mnt baca`;

    // Keyword density quick badge
    const densityBadge = document.getElementById('kwDensityBadge');
    if (focusKeyword && words > 0) {
        let occ = 0;
        let pos = content.toLowerCase().indexOf(focusKeyword);
        while (pos !== -1) { occ++; pos = content.toLowerCase().indexOf(focusKeyword, pos + focusKeyword.length); }
        const kwWords = Math.max(1, countWords(focusKeyword));
        const den = ((occ * kwWords / words) * 100).toFixed(1);
        densityBadge.innerText = `Muncul: ${occ}x (${den}%)`;
        densityBadge.className = `badge ${den >= 0.5 && den <= 3.0 ? 'bg-success' : (den > 3.0 ? 'bg-danger' : 'bg-warning')}`;
    } else {
        densityBadge.innerText = 'Kepadatan: 0%';
        densityBadge.className = 'badge bg-secondary';
    }
}

function updateSerpPreview(title, slug, metaDesc, content) {
    const serpTitle = document.getElementById('serpTitle');
    const serpUrl = document.getElementById('serpUrl');
    const serpSnippet = document.getElementById('serpSnippet');

    const displayTitle = (title || 'Judul Berita Artikel Anda') + ' - PT Makmur Bersama Enjiniring';
    serpTitle.innerText = displayTitle.length > 70 ? displayTitle.substring(0, 67) + '...' : displayTitle;
    
    serpUrl.innerText = `https://makben.co.id › berita › ${slug || 'judul-berita'}`;

    const snippetText = metaDesc || (content ? content.substring(0, 155) + '...' : 'Tuliskan deskripsi meta yang menarik agar calon pelanggan mengklik tautan Anda saat mencari layanan manufaktur atau fabrikasi...');
    serpSnippet.innerText = snippetText.length > 165 ? snippetText.substring(0, 162) + '...' : snippetText;
}

function renderChecklistUI(checks, score, hasKeyword) {
    const listPassed = document.getElementById('listPassed');
    const listWarning = document.getElementById('listWarning');
    const listFailed = document.getElementById('listFailed');

    listPassed.innerHTML = '';
    listWarning.innerHTML = '';
    listFailed.innerHTML = '';

    let countPassed = 0;
    let countWarning = 0;
    let countFailed = 0;

    checks.forEach(c => {
        const item = document.createElement('div');
        item.className = `seo-check-item item-${c.status}`;

        let iconHtml = '';
        if (c.status === 'passed') {
            iconHtml = '<i class="fa-solid fa-circle-check text-success"></i>';
            countPassed++;
        } else if (c.status === 'warning') {
            iconHtml = '<i class="fa-solid fa-triangle-exclamation text-warning"></i>';
            countWarning++;
        } else {
            iconHtml = '<i class="fa-solid fa-circle-xmark text-danger"></i>';
            countFailed++;
        }

        item.innerHTML = `
            <div class="seo-check-header">
                ${iconHtml}
                <span>${c.label}</span>
                <span class="badge ${c.status === 'passed' ? 'bg-success' : (c.status === 'warning' ? 'bg-warning text-dark' : 'bg-danger')} ms-auto" style="font-size: 0.72rem;">${c.score}/${c.max_score || 10}</span>
            </div>
            <div class="seo-check-exp">${c.exp}</div>
            <div class="seo-check-rec"><i class="fa-solid fa-arrow-right"></i> ${c.rec}</div>
        `;

        if (c.status === 'passed') {
            listPassed.appendChild(item);
        } else if (c.status === 'warning') {
            listWarning.appendChild(item);
        } else {
            listFailed.appendChild(item);
        }
    });

    document.getElementById('countPassed').innerText = countPassed;
    document.getElementById('countWarning').innerText = countWarning;
    document.getElementById('countFailed').innerText = countFailed;

    document.getElementById('groupPassedContainer').style.display = countPassed > 0 ? 'block' : 'none';
    document.getElementById('groupWarningContainer').style.display = countWarning > 0 ? 'block' : 'none';
    document.getElementById('groupFailedContainer').style.display = countFailed > 0 ? 'block' : 'none';

    // Update Score Gauge & Badges
    const scoreText = document.getElementById('seoScoreText');
    const statusBadge = document.getElementById('seoStatusBadge');
    const gauge = document.getElementById('seoGauge');
    const incompleteNotice = document.getElementById('seoIncompleteNotice');

    scoreText.innerText = score + '%';
    const deg = (score / 100) * 360;

    let color = '#f44336';
    let statusText = 'Kurang (Poor SEO)';

    if (!hasKeyword) {
        color = '#64748b';
        statusText = 'Analisis Belum Lengkap';
        incompleteNotice.style.display = 'block';
    } else {
        incompleteNotice.style.display = 'none';
        if (score >= 80) {
            color = '#00a859';
            statusText = 'Bagus (Good SEO)';
        } else if (score >= 60) {
            color = '#ff9800';
            statusText = 'Perlu Perbaikan (OK)';
        }
    }

    scoreText.style.color = color;
    statusBadge.style.color = color;
    statusBadge.innerText = statusText;
    gauge.style.background = `conic-gradient(${color} ${deg}deg, #edf2f7 ${deg}deg)`;
}

// Asynchronously verify against authoritative Server Engine (Debounced)
function verifySeoWithServer() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        const payload = {
            title: document.getElementById('title').value,
            meta_title: document.getElementById('meta_title').value,
            focus_keyword: document.getElementById('focus_keyword').value,
            meta_description: document.getElementById('meta_description').value,
            slug: document.getElementById('slug').value,
            content: document.getElementById('content').value,
            image_alt: document.getElementById('image_alt').value,
            image: document.getElementById('imagePreview').src || ''
        };

        const syncBadge = document.getElementById('syncIndicator');
        syncBadge.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-primary"></i> Memeriksa...';

        fetch(ANALYZE_ENDPOINT, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            syncBadge.innerHTML = '<i class="fa-solid fa-circle-check text-success"></i> Terverifikasi';
        })
        .catch(err => {
            syncBadge.innerHTML = '<i class="fa-solid fa-bolt text-warning"></i> Real-time';
        });
    }, 600);
}

function runSeoAnalysis() {
    evaluateSeoLocal();
    verifySeoWithServer();
}

// Event Listeners for real-time reactivity
document.addEventListener('DOMContentLoaded', function() {
    const inputs = ['title', 'slug', 'meta_title', 'focus_keyword', 'meta_description', 'content', 'image_alt'];
    inputs.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', runSeoAnalysis);
            el.addEventListener('keyup', runSeoAnalysis);
            el.addEventListener('change', runSeoAnalysis);
        }
    });

    // Auto-generate slug from title if slug input is empty
    const titleEl = document.getElementById('title');
    const slugEl = document.getElementById('slug');
    if (titleEl && slugEl) {
        titleEl.addEventListener('input', function() {
            if (!slugEl.dataset.customized) {
                slugEl.value = slugify(titleEl.value);
            }
        });
        slugEl.addEventListener('input', function() {
            slugEl.dataset.customized = 'true';
        });
    }

    runSeoAnalysis();
});
</script>
@endpush
