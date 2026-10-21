@extends('admin.layouts.app')

@section('title', isset($news) ? 'Edit Berita' : 'Tambah Berita Baru')

@push('styles')
<style>
    .form-label {
        font-weight: 700;
        font-size: 0.88rem;
        color: #2d3748;
        margin-bottom: 6px;
        display: block;
    }
    .form-control-custom {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: border-color 0.2s;
    }
    .form-control-custom:focus {
        border-color: #0191b3;
        outline: none;
    }
</style>
@endpush

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('admin.news.index') }}" style="color: #64748b; text-decoration: none; font-size: 0.9rem; font-weight: 600;">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Berita
    </a>
    <h1 style="font-size: 1.8rem; font-weight: 800; color: #1e293b; margin-top: 8px;">
        {{ isset($news) ? 'Edit Berita' : 'Tambah Berita Baru (CMS)' }}
    </h1>
</div>

<form action="{{ isset($news) ? route('admin.news.update', $news->id) : route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($news))
        @method('PUT')
    @endif

    <div style="display: grid; grid-template-columns: 2.2fr 1fr; gap: 24px;">
        
        <!-- LEFT COLUMN: MAIN EDITOR -->
        <div>
            <div class="card-admin">
                <!-- JUDUL -->
                <div class="form-group">
                    <label class="form-label" for="title">JUDUL BERITA *</label>
                    <input type="text" name="title" id="title" class="form-control-custom" value="{{ old('title', $news->title ?? '') }}" required placeholder="Contoh: PT MBE Tambah Mesin CNC Presisi Baru 2026">
                </div>

                <!-- TANGGAL & HEADLINE OPTION -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 18px;">
                    <div>
                        <label class="form-label" for="published_at">TANGGAL PUBLIKASI *</label>
                        <input type="date" name="published_at" id="published_at" class="form-control-custom" value="{{ old('published_at', isset($news->published_at) ? $news->published_at->format('Y-m-d') : date('Y-m-d')) }}" required>
                    </div>
                    <div style="display: flex; align-items: flex-end;">
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 10px 14px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; width: 100%; font-weight: 600; color: #0191b3;">
                            <input type="checkbox" name="is_headline" value="1" {{ old('is_headline', $news->is_headline ?? false) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #0191b3;">
                            <span><i class="fa-solid fa-star"></i> Jadikan Headline Utama Beranda</span>
                        </label>
                    </div>
                </div>

                <!-- GAMBAR UPLOAD -->
                <div class="form-group" style="margin-top: 18px;">
                    <label class="form-label" for="image">GAMBAR UTAMA (FEATURED IMAGE)</label>
                    <input type="file" name="image" id="image" class="form-control-custom" accept="image/*" onchange="previewImage(this)">
                    
                    <span style="font-size: 0.82rem; color: #0191b3; display: block; margin-top: 6px;">
                        <i class="fa-solid fa-lightbulb"></i> <strong>Saran Ukuran Gambar Berita:</strong> Rekomendasi resolusi <strong>1200 x 675 px</strong> atau <strong>1600 x 900 px</strong> (Rasio Landscape 16:9). Format: JPG, PNG, WEBP. Max 5MB.
                    </span>
                    
                    <div id="imagePreviewContainer" style="margin-top: 12px; {{ isset($news) && $news->image ? '' : 'display:none;' }}">
                        <img id="imagePreview" src="{{ isset($news) && $news->image ? asset($news->image) : '' }}" style="max-height: 180px; border-radius: 8px; border: 1px solid #cbd5e1;">
                    </div>
                </div>

                <!-- RINGKASAN EXCERPT -->
                <div class="form-group" style="margin-top: 18px;">
                    <label class="form-label" for="excerpt">RINGKASAN SINGKAT (EXCERPT)</label>
                    <textarea name="excerpt" id="excerpt" class="form-control-custom" style="min-height: 80px;" placeholder="Tuliskan ringkasan 1-2 kalimat untuk tampilan kartu di beranda...">{{ old('excerpt', $news->excerpt ?? '') }}</textarea>
                </div>

                <!-- ISI KONTEN -->
                <div class="form-group" style="margin-top: 18px;">
                    <label class="form-label" for="content">ISI BERITA LENGKAP *</label>
                    <textarea name="content" id="content" class="form-control-custom" style="min-height: 250px;" required placeholder="Tuliskan isi artikel berita lengkap di sini...">{{ old('content', $news->content ?? '') }}</textarea>
                </div>
            </div>

            <!-- SEO META CONFIGURATION -->
            <div class="card-admin">
                <h3 style="font-size: 1.2rem; font-weight: 700; color: #12181f; margin-bottom: 20px; border-bottom: 2px solid #f0f4f8; padding-bottom: 10px;">
                    <i class="fa-solid fa-magnifying-glass-chart" style="color: #0191b3;"></i> Pengaturan SEO & Meta Google
                </h3>

                <div class="form-group">
                    <label class="form-label" for="focus_keyword">FOCUS KEYWORD (KATA KUNCI UTAMA)</label>
                    <input type="text" name="focus_keyword" id="focus_keyword" class="form-control-custom" value="{{ old('focus_keyword', $news->focus_keyword ?? '') }}" placeholder="Contoh: Fabrikasi Cirebon, Machining CNC MBE" onkeyup="evaluateSeo()">
                </div>

                <div class="form-group" style="margin-top: 18px;">
                    <label class="form-label" for="meta_title">META TITLE GOOGLE</label>
                    <input type="text" name="meta_title" id="meta_title" class="form-control-custom" value="{{ old('meta_title', $news->meta_title ?? '') }}" placeholder="Kosongkan jika samakan dengan judul berita">
                </div>

                <div class="form-group" style="margin-top: 18px;">
                    <label class="form-label" for="meta_description">META DESCRIPTION GOOGLE</label>
                    <textarea name="meta_description" id="meta_description" class="form-control-custom" style="min-height: 80px;" placeholder="Deskripsi ringkas yang tampil di hasil pencarian Google (idealnya 120-160 karakter)..." onkeyup="evaluateSeo()">{{ old('meta_description', $news->meta_description ?? '') }}</textarea>
                </div>
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" class="btn-pill btn-pill-primary" style="padding: 14px 40px; font-size: 1.05rem;">
                    <i class="fa-solid fa-floppy-disk"></i> {{ isset($news) ? 'Simpan Perubahan Berita' : 'Terbitkan Berita Sekarang' }}
                </button>
            </div>
        </div>

        <!-- RIGHT COLUMN: YOAST-STYLE LIVE SEO SCORE EVALUATOR -->
        <div>
            <div class="card-admin" style="position: sticky; top: 90px;">
                <h3 style="font-size: 1.15rem; font-weight: 800; color: #12181f; margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between;">
                    <span><i class="fa-solid fa-chart-pie" style="color: #0191b3;"></i> SEO Score Evaluator</span>
                </h3>

                <!-- LIVE SCORE GAUGE METER -->
                <div style="text-align: center; padding: 20px 0; border-bottom: 1px solid #edf2f7; margin-bottom: 20px;">
                    <div id="seoGauge" style="width: 110px; height: 110px; border-radius: 50%; background: conic-gradient(#f44336 0deg, #edf2f7 0deg); display: flex; align-items: center; justify-content: center; margin: 0 auto; transition: all 0.5s ease;">
                        <div style="width: 86px; height: 86px; background: #ffffff; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                            <span id="seoScoreText" style="font-size: 1.8rem; font-weight: 800; color: #f44336;">0%</span>
                        </div>
                    </div>
                    <div id="seoStatusBadge" style="margin-top: 12px; font-weight: 700; font-size: 0.95rem; color: #f44336;">
                        Kurang (Poor SEO)
                    </div>
                </div>

                <!-- LIVE SEO CHECKLIST -->
                <h4 style="font-size: 0.9rem; font-weight: 700; color: #4a5568; margin-bottom: 12px; text-transform: uppercase;">Checklist Parameter SEO:</h4>
                <ul id="seoChecklist" style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 10px; font-size: 0.88rem;">
                    <li id="check-title" style="color: #e53e3e; display: flex; gap: 8px; align-items: flex-start;">
                        <i class="fa-solid fa-circle-xmark" style="margin-top: 3px;"></i> Panjang Judul Berita (35 - 65 Karakter)
                    </li>
                    <li id="check-meta" style="color: #e53e3e; display: flex; gap: 8px; align-items: flex-start;">
                        <i class="fa-solid fa-circle-xmark" style="margin-top: 3px;"></i> Meta Description (110 - 170 Karakter)
                    </li>
                    <li id="check-words" style="color: #e53e3e; display: flex; gap: 8px; align-items: flex-start;">
                        <i class="fa-solid fa-circle-xmark" style="margin-top: 3px;"></i> Jumlah Kata Konten Minimal 150 Kata
                    </li>
                    <li id="check-keyword" style="color: #e53e3e; display: flex; gap: 8px; align-items: flex-start;">
                        <i class="fa-solid fa-circle-xmark" style="margin-top: 3px;"></i> Focus Keyword ada di Judul & Isi Konten
                    </li>
                    <li id="check-image" style="color: #e53e3e; display: flex; gap: 8px; align-items: flex-start;">
                        <i class="fa-solid fa-circle-xmark" style="margin-top: 3px;"></i> Ada Gambar Utama (Featured Image)
                    </li>
                </ul>
            </div>
        </div>

    </div>
</form>

@endsection

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const container = document.getElementById('imagePreviewContainer');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.style.display = 'block';
            evaluateSeo();
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function evaluateSeo() {
    const title = document.getElementById('title').value.trim();
    const metaDesc = document.getElementById('meta_description').value.trim();
    const content = document.getElementById('content').value.replace(/<[^>]*>?/gm, '').trim();
    const keyword = document.getElementById('focus_keyword').value.trim().toLowerCase();
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');

    let score = 0;

    // 1. Title Check
    const titleCheck = document.getElementById('check-title');
    if (title.length >= 35 && title.length <= 65) {
        score += 20;
        titleCheck.style.color = '#00a859';
        titleCheck.querySelector('i').className = 'fa-solid fa-circle-check';
    } else {
        titleCheck.style.color = '#e53e3e';
        titleCheck.querySelector('i').className = 'fa-solid fa-circle-xmark';
    }

    // 2. Meta Desc Check
    const metaCheck = document.getElementById('check-meta');
    if (metaDesc.length >= 110 && metaDesc.length <= 170) {
        score += 20;
        metaCheck.style.color = '#00a859';
        metaCheck.querySelector('i').className = 'fa-solid fa-circle-check';
    } else {
        metaCheck.style.color = '#e53e3e';
        metaCheck.querySelector('i').className = 'fa-solid fa-circle-xmark';
    }

    // 3. Word Count Check
    const wordsCheck = document.getElementById('check-words');
    const words = content.length > 0 ? content.split(/\s+/).length : 0;
    if (words >= 150) {
        score += 20;
        wordsCheck.style.color = '#00a859';
        wordsCheck.querySelector('i').className = 'fa-solid fa-circle-check';
    } else {
        wordsCheck.style.color = '#e53e3e';
        wordsCheck.querySelector('i').className = 'fa-solid fa-circle-xmark';
    }

    // 4. Focus Keyword Check
    const kwCheck = document.getElementById('check-keyword');
    if (keyword.length > 0 && title.toLowerCase().includes(keyword) && content.toLowerCase().includes(keyword)) {
        score += 20;
        kwCheck.style.color = '#00a859';
        kwCheck.querySelector('i').className = 'fa-solid fa-circle-check';
    } else {
        kwCheck.style.color = '#e53e3e';
        kwCheck.querySelector('i').className = 'fa-solid fa-circle-xmark';
    }

    // 5. Featured Image Check
    const imgCheck = document.getElementById('check-image');
    if ((imageInput && imageInput.files.length > 0) || (imagePreview && imagePreview.src && imagePreview.src.length > 10 && !imagePreview.src.endsWith('/'))) {
        score += 20;
        imgCheck.style.color = '#00a859';
        imgCheck.querySelector('i').className = 'fa-solid fa-circle-check';
    } else {
        imgCheck.style.color = '#e53e3e';
        imgCheck.querySelector('i').className = 'fa-solid fa-circle-xmark';
    }

    // Update Score Meter
    const scoreText = document.getElementById('seoScoreText');
    const statusBadge = document.getElementById('seoStatusBadge');
    const gauge = document.getElementById('seoGauge');

    scoreText.innerText = score + '%';
    const deg = (score / 100) * 360;

    let color = '#f44336';
    let statusText = 'Kurang (Poor SEO)';

    if (score >= 80) {
        color = '#00a859';
        statusText = 'Bagus (Good SEO)';
    } else if (score >= 50) {
        color = '#ff9800';
        statusText = 'Cukup (OK SEO)';
    }

    scoreText.style.color = color;
    statusBadge.style.color = color;
    statusBadge.innerText = statusText;
    gauge.style.background = `conic-gradient(${color} ${deg}deg, #edf2f7 ${deg}deg)`;
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('title').addEventListener('keyup', evaluateSeo);
    document.getElementById('content').addEventListener('keyup', evaluateSeo);
    evaluateSeo();
});
</script>
@endpush
