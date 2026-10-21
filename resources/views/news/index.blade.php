@extends('layouts.app')

@section('title', 'Berita & Artikel - PT Makmur Bersama Enjiniring')

@section('content')

<!-- PAGE BANNER -->
<section class="page-sub-banner">
    <div class="container text-center">
        <div class="pdf-section-header" style="margin-bottom: 0;">
            <div class="pdf-header-divider">
                <span></span><i class="fa-solid fa-gear"></i><span></span>
            </div>
            <h1 class="pdf-section-title">Berita & Informasi</h1>
        </div>
    </div>
</section>

<!-- NEWS GRID SECTION -->
<section class="section-padding" style="background-color: #ffffff;">
    <div class="container">
        <div class="grid-3">
            @forelse($newsList as $item)
            <div class="news-card" style="border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; display: flex; flex-direction: column;">
                <img src="{{ $item->image ? asset($item->image) : asset('assets/images/page_beranda/foto produk kami machining CNC.png') }}" alt="{{ $item->title }}" class="news-img" style="height: 200px; object-fit: cover;">
                <div class="news-body" style="padding: 20px; display: flex; flex-direction: column; flex-grow: 1;">
                    <div class="news-date" style="color: #0191b3; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px;">
                        <i class="fa-regular fa-calendar-days"></i> {{ \Carbon\Carbon::parse($item->published_at)->format('d M Y') }}
                    </div>
                    <h3 class="news-title" style="font-size: 1.15rem; font-weight: 700; color: #12181f; margin-bottom: 10px; line-height: 1.4;">
                        <a href="{{ route('news.show', $item->slug) }}" style="color: inherit;">{{ $item->title }}</a>
                    </h3>
                    <p class="news-excerpt" style="font-size: 0.9rem; color: #666; margin-bottom: 20px; line-height: 1.5;">
                        {{ $item->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($item->content), 100) }}
                    </p>
                    <div style="margin-top: auto;">
                        <a href="{{ route('news.show', $item->slug) }}" class="btn-pill btn-pill-primary" style="padding: 6px 18px; font-size: 0.85rem;">
                            Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 0; color: #718096;">
                Belum ada artikel berita yang diterbitkan.
            </div>
            @endforelse
        </div>

        <div style="margin-top: 40px; display: flex; justify-content: center;">
            {{ $newsList->links() }}
        </div>
    </div>
</section>

@endsection
