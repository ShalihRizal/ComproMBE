@extends('layouts.app')

@section('title', ($news->meta_title ?? $news->title) . ' - PT Makmur Bersama Enjiniring')

@push('styles')
@if($news->meta_description)
<meta name="description" content="{{ $news->meta_description }}">
@endif
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
        <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 12px; font-size: 0.9rem; color: #0191b3; font-weight: 600;">
            <span><i class="fa-regular fa-calendar-days"></i> {{ \Carbon\Carbon::parse($news->published_at)->format('d F Y') }}</span>
            @if($news->is_headline)
            <span class="news-badge" style="background: #00a859;"><i class="fa-solid fa-star"></i> Headline Utama</span>
            @endif
        </div>

        <h1 style="font-size: 2.3rem; font-weight: 800; color: #12181f; margin-bottom: 24px; line-height: 1.3;">{{ $news->title }}</h1>

        @if($news->image)
        <div style="margin-bottom: 30px; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-md);">
            <img src="{{ asset($news->image) }}" alt="{{ $news->title }}" style="width: 100%; max-height: 480px; object-fit: cover;">
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
