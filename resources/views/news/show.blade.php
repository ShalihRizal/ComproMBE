@extends('layouts.app')

@php
    $pageTitle = $news->meta_title ?: $news->title;
    $metaDescription = $news->meta_description ?: ($news->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($news->content), 155));
    $canonicalUrl = route('news.show', $news->slug);
    $imageUrl = $news->image ? asset($news->image) : asset('assets/images/page_beranda/logo makben.png');
    $altText = $news->image_alt_or_title;
@endphp

@section('title', $pageTitle . ' - PT Makmur Bersama Enjiniring')
@section('meta_description', $metaDescription)
@if($news->focus_keyword)
@section('meta_keywords', $news->focus_keyword . ', PT Makmur Bersama Enjiniring, Berita MBE')
@endif
@section('canonical_url', $canonicalUrl)
@section('og_type', 'article')
@section('og_title', $pageTitle)
@section('og_image', $imageUrl)

@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "NewsArticle",
  "headline": {!! json_encode(strip_tags($pageTitle), JSON_HEX_TAG | JSON_HEX_AMP) !!},
  "description": {!! json_encode(strip_tags($metaDescription), JSON_HEX_TAG | JSON_HEX_AMP) !!},
  "image": [{!! json_encode($imageUrl, JSON_HEX_TAG | JSON_HEX_AMP) !!}],
  "datePublished": {!! json_encode($news->published_at ? $news->published_at->toIso8601String() : $news->created_at->toIso8601String()) !!},
  "dateModified": {!! json_encode($news->updated_at->toIso8601String()) !!},
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": {!! json_encode($canonicalUrl, JSON_HEX_TAG | JSON_HEX_AMP) !!}
  },
  "author": {
    "@type": "Organization",
    "name": "PT Makmur Bersama Enjiniring",
    "url": {!! json_encode(url('/'), JSON_HEX_TAG | JSON_HEX_AMP) !!}
  },
  "publisher": {
    "@type": "Organization",
    "name": "PT Makmur Bersama Enjiniring",
    "logo": {
      "@type": "ImageObject",
      "url": {!! json_encode(asset('assets/images/page_beranda/logo makben.png'), JSON_HEX_TAG | JSON_HEX_AMP) !!}
    }
  }
}
</script>
@endpush

@push('styles')
<style>
    .article-body h2, .article-body h3 {
        color: #12181f;
        font-weight: 800;
        margin-top: 36px;
        margin-bottom: 16px;
        line-height: 1.35;
    }
    .article-body h2 {
        font-size: 1.65rem;
    }
    .article-body h3 {
        font-size: 1.35rem;
    }
    .article-body p {
        margin-bottom: 20px;
        line-height: 1.85;
    }
    .article-body a {
        color: #0056b3 !important;
        font-weight: 700 !important;
        text-decoration: underline !important;
        transition: color 0.2s ease;
    }
    .article-body a:hover {
        color: #003875 !important;
    }
    .article-body figure {
        margin: 32px 0;
        text-align: left;
    }
    .article-body figure img, .article-body img {
        width: 100%;
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        margin: 12px 0;
    }
    .article-body figcaption {
        font-size: 0.88rem;
        color: #64748b;
        margin-top: 8px;
        font-weight: 500;
    }
</style>
@endpush

@section('content')

<!-- PAGE BANNER -->
<section class="page-sub-banner">
    <div class="container text-center">
        <div class="pdf-section-header" style="margin-bottom: 0;">
            <div class="pdf-header-divider">
                <span></span><i class="fa-solid fa-gear"></i><span></span>
            </div>
            <h1 class="pdf-section-title">Detail Berita</h1>
        </div>
    </div>
</section>

<!-- SINGLE ARTICLE CONTENT -->
<section class="section-padding" style="background-color: #ffffff;">
    <div class="container" style="max-width: 900px;">
        @if(isset($isPreview) && $isPreview)
        <div style="background: #fffbeb; border: 2px solid #f59e0b; border-radius: 12px; padding: 16px 20px; margin-bottom: 24px; box-shadow: 0 4px 14px rgba(245, 158, 11, 0.15);">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="background: #f59e0b; color: #fff; width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                    <div>
                        <strong style="color: #92400e; font-size: 1.05rem;">Mode Pratinjau Admin</strong>
                        <div style="color: #b45309; font-size: 0.88rem; margin-top: 2px;">
                            Status Artikel: 
                            @if($news->isDraft())
                                <span class="badge bg-warning text-dark px-2 py-1"><i class="fa-solid fa-file-pen"></i> Draft (Belum Tayang ke Publik)</span>
                            @elseif($news->isScheduled())
                                <span class="badge bg-info text-dark px-2 py-1"><i class="fa-solid fa-clock"></i> Terjadwal (Tayang Otomatis: {{ $news->published_at ? $news->published_at->format('d M Y, H:i') : '' }} WIB)</span>
                            @else
                                <span class="badge bg-secondary px-2 py-1">Pratinjau Khusus</span>
                            @endif
                        </div>
                    </div>
                </div>
                @if(session('admin_logged_in'))
                <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-sm btn-warning fw-bold px-3 py-2" style="border-radius: 8px;">
                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit Artikel
                </a>
                @endif
            </div>
        </div>
        @endif

        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px; font-size: 0.9rem; color: #0191b3; font-weight: 600; flex-wrap: wrap;">
            <span><i class="fa-regular fa-calendar-days"></i> {{ \Carbon\Carbon::parse($news->published_at)->format('d F Y') }}</span>
            @if($news->category)
            <span class="news-badge" style="background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; font-weight: 700; padding: 3px 10px; border-radius: 20px; font-size: 0.82rem;">
                <i class="fa-solid fa-tag"></i> {{ $news->category }}
            </span>
            @endif
            @if($news->is_headline)
            <span class="news-badge" style="background: #00a859;"><i class="fa-solid fa-star"></i> Headline Utama</span>
            @endif
        </div>

        <h1 style="font-size: 2.3rem; font-weight: 800; color: #12181f; margin-bottom: 24px; line-height: 1.3;">{{ $news->title }}</h1>

        @if($news->image)
        <div style="margin-bottom: 30px; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-md);">
            <img src="{{ asset($news->image) }}" alt="{{ $altText }}" style="width: 100%; max-height: 480px; object-fit: cover;">
        </div>
        @endif

        <div style="font-size: 1.08rem; line-height: 1.8; color: var(--text-dark);" class="article-body">
            @if($news->excerpt)
            <div style="font-size: 1.15rem; font-weight: 600; color: #2d3748; background: #f7fafc; padding: 20px; border-left: 4px solid #0191b3; border-radius: 6px; margin-bottom: 24px;">
                {{ $news->excerpt }}
            </div>
            @endif

            {!! $news->content !!}
        </div>

        <!-- RECENT ARTICLES RECOMMENDATION -->
        @if(isset($recentNews) && count($recentNews) > 0)
        <div style="margin-top: 60px; padding-top: 40px; border-top: 2px solid #edf2f7;">
            <h3 style="font-size: 1.4rem; font-weight: 800; color: #12181f; margin-bottom: 20px;">Berita Terbaru Lainnya</h3>
            <div class="grid-3">
                @foreach($recentNews as $rItem)
                <div class="news-card" style="border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden;">
                    <img src="{{ $rItem->image ? asset($rItem->image) : asset('assets/images/page_beranda/foto produk kami machining CNC.png') }}" alt="{{ $rItem->title }}" style="height: 140px; width: 100%; object-fit: cover;">
                    <div style="padding: 14px;">
                        <h4 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 8px;">
                            <a href="{{ route('news.show', $rItem->slug) }}" style="color: #12181f;">{{ $rItem->title }}</a>
                        </h4>
                        <a href="{{ route('news.show', $rItem->slug) }}" style="color: #0191b3; font-size: 0.82rem; font-weight: 700;">Baca Artikel <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div style="margin-top: 40px;">
            <a href="{{ route('news.index') }}" class="btn-pill btn-pill-outline">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Berita
            </a>
        </div>
    </div>
</section>

@endsection
