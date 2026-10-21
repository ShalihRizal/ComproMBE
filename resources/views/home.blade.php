@extends('layouts.app')

@section('title', 'Beranda - PT Makmur Bersama Enjiniring')

@section('content')

<!-- HERO SECTION (MANUFACTURING BACKGROUND MATCHING PAGE 1 PDF) -->
<section class="pdf-hero">
    <div class="pdf-hero-overlay"></div>
    <div class="container pdf-hero-container">
        <div class="pdf-hero-content">
            <h1 class="pdf-hero-title">PT MAKMUR BERSAMA ENJINIRING</h1>
            <p class="pdf-hero-description">
                Solusi terpercaya kebutuhan Industri, Fabrikasi, Machining, Manufaktur Extruder, Injeksi Plastik & General Trading dengan standar kualitas dan presisi terbaik.
            </p>
            <div style="display: flex; gap: 14px; flex-wrap: wrap;">
                <a href="{{ route('contact') }}" class="btn-pill btn-pill-green">
                    <i class="fa-brands fa-whatsapp"></i> Hubungi Kami
                </a>
                <a href="{{ route('products.index') }}" class="btn-pill btn-pill-outline">
                    Lihat Produk
                </a>
            </div>
        </div>
    </div>
</section>

<!-- FLOATING STATS STRIP (MATCHING PAGE 1 PDF) -->
<div class="stats-strip">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">10+</div>
                <div class="stat-label">Tahun Pengalaman</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">500+</div>
                <div class="stat-label">Proyek Selesai</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">100%</div>
                <div class="stat-label">Kepuasan Klien</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Dukungan Layanan</div>
            </div>
        </div>
    </div>
</div>

<!-- ABOUT US / SEKILAS PERUSAHAAN (MATCHING PAGE 1 PDF) -->
<section class="section-padding" style="background: #ffffff;">
    <div class="container">
        <div class="grid-2" style="align-items: center; gap: 50px;">
            <div>
                <img src="{{ asset('assets/images/page_profile/kalimas area depan.png') }}" alt="Workshop MBE Kalimas" style="width: 100%; border-radius: 16px; box-shadow: var(--shadow-lg);" class="lightbox-trigger">
            </div>
            <div>
                <div class="pdf-section-header" style="text-align: left; margin-bottom: 20px;">
                    <h2 class="pdf-section-title" style="font-size: 2.2rem;">Tentang PT Makmur Bersama Enjiniring</h2>
                </div>
                <p style="font-size: 1rem; color: #475569; line-height: 1.8; margin-bottom: 24px; text-align: justify;">
                    PT Makmur Bersama Enjiniring (MBE) adalah perusahaan yang bergerak di bidang manufaktur, fabrikasi logam, pengerjaan machining CNC presisi tinggi, serta pengadaan material dan peralatan industri. Didukung oleh workshop yang memadai dan tenaga profesional, kami berkomitmen memberikan hasil terbaik bagi mitra kerja.
                </p>
                <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                    <a href="{{ route('profile') }}" class="btn-pill btn-pill-primary">Selengkapnya Profil Kami</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PORTOFOLIO SINGKAT (MATCHING PAGE 1 PDF) -->
<section class="section-padding" style="background-color: var(--light-bg);">
    <div class="container text-center">
        <div class="pdf-section-header">
            <div class="pdf-header-divider">
                <span></span><i class="fa-solid fa-gear"></i><span></span>
            </div>
            <h2 class="pdf-section-title">Portofolio Pekerjaan Kami</h2>
        </div>

        <div class="grid-4" style="margin-bottom: 30px;">
            <div class="portfolio-item" style="height: 200px;">
                <img src="{{ asset('assets/images/page_portoflio/portof1.png') }}" alt="Portofolio 1" class="lightbox-trigger">
            </div>
            <div class="portfolio-item" style="height: 200px;">
                <img src="{{ asset('assets/images/page_portoflio/portof2.png') }}" alt="Portofolio 2" class="lightbox-trigger">
            </div>
            <div class="portfolio-item" style="height: 200px;">
                <img src="{{ asset('assets/images/page_portoflio/portof3.png') }}" alt="Portofolio 3" class="lightbox-trigger">
            </div>
            <div class="portfolio-item" style="height: 200px;">
                <img src="{{ asset('assets/images/page_portoflio/portof4.png') }}" alt="Portofolio 4" class="lightbox-trigger">
            </div>
        </div>

        <div>
            <a href="{{ route('portfolio') }}" class="btn-pill btn-pill-primary">Lihat Selengkapnya</a>
        </div>
    </div>
</section>

<!-- LAYANAN KAMI SECTION (MATCHING PAGE 1 PDF) -->
<section class="section-padding" style="background-color: #ffffff;">
    <div class="container text-center">
        <div class="pdf-section-header">
            <div class="pdf-header-divider">
                <span></span><i class="fa-solid fa-gear"></i><span></span>
            </div>
            <h2 class="pdf-section-title">Layanan Kami</h2>
        </div>

        <div class="grid-5" style="margin-bottom: 30px;">
            <a href="{{ route('services') }}#bending" class="service-square-card">
                <img src="{{ asset('assets/images/page_beranda/icon bending.png') }}" alt="Bending">
                <div class="service-square-title">BENDING</div>
            </a>
            
            <a href="{{ route('services') }}#laser-cutting" class="service-square-card">
                <img src="{{ asset('assets/images/page_beranda/icon laser cutting.png') }}" alt="Laser Cutting">
                <div class="service-square-title">LASER CUTTING</div>
            </a>

            <a href="{{ route('services') }}#welding" class="service-square-card active">
                <img src="{{ asset('assets/images/page_beranda/icon welding.png') }}" alt="Welding">
                <div class="service-square-title">WELDING</div>
            </a>

            <a href="{{ route('services') }}#ducting" class="service-square-card">
                <img src="{{ asset('assets/images/page_beranda/icon ducting.png') }}" alt="Ducting">
                <div class="service-square-title">DUCTING</div>
            </a>

            <a href="{{ route('services') }}#piping" class="service-square-card">
                <img src="{{ asset('assets/images/page_beranda/icon piping.png') }}" alt="Piping">
                <div class="service-square-title">PIPING</div>
            </a>
        </div>
    </div>
</section>

<!-- DYNAMIC PRODUK KAMI SECTION (FROM MYSQL DB) -->
<section class="section-padding" style="background-color: var(--light-bg);">
    <div class="container">
        <div class="pdf-section-header">
            <div class="pdf-header-divider">
                <span></span><i class="fa-solid fa-gear"></i><span></span>
            </div>
            <h2 class="pdf-section-title">Produk Kami</h2>
        </div>

        <div class="product-interactive-box">
            <div class="product-interactive-content grid-2">
                <div class="product-menu-list">
                    @foreach($productCategories as $index => $cat)
                    <a href="{{ route('products.show', $cat->slug) }}" class="product-menu-item {{ $index === 0 ? 'active' : '' }}">{{ $cat->name }}</a>
                    @endforeach
                </div>
                <div>
                    <img src="{{ optional($productCategories->first())->header_image_url }}" alt="Preview Produk MBE" style="width: 100%; border-radius: 8px; box-shadow: var(--shadow-lg);" class="lightbox-trigger">
                </div>
            </div>
        </div>

        <!-- CTA BUTTONS (MATCHING PAGE 1 PDF) -->
        <div style="display: flex; gap: 20px; justify-content: center; margin-top: 50px;">
            <a href="{{ route('contact') }}" class="btn-pill btn-pill-green">Hubungi Kami</a>
            <a href="{{ route('contact') }}" class="btn-pill btn-pill-green">Minta Penawaran</a>
        </div>
    </div>
</section>

<!-- BERITA TERKINI SECTION -->
@if(isset($headlineNews) || (isset($recentNews) && count($recentNews) > 0))
<section class="section-padding" style="background-color: #ffffff;">
    <div class="container">
        <div class="pdf-section-header text-center">
            <div class="pdf-header-divider">
                <span></span><i class="fa-solid fa-newspaper"></i><span></span>
            </div>
            <h2 class="pdf-section-title">Berita & Artikel Terkini</h2>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-top: 30px;">
            @if($headlineNews)
            <div style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; display: flex; flex-direction: column;">
                <img src="{{ $headlineNews->image_url }}" alt="{{ $headlineNews->title }}" style="width: 100%; height: 220px; object-fit: cover;">
                <div style="padding: 20px; flex: 1; display: flex; flex-direction: column;">
                    <span style="font-size: 0.8rem; color: #0191b3; font-weight: 700; margin-bottom: 8px;">HEADLINE</span>
                    <h3 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 10px;">
                        <a href="{{ route('news.show', $headlineNews->slug) }}" style="color: inherit; text-decoration: none;">{{ $headlineNews->title }}</a>
                    </h3>
                    <p style="font-size: 0.88rem; color: #64748b; line-height: 1.5; margin-bottom: 16px; flex: 1;">
                        {{ \Illuminate\Support\Str::limit(strip_tags($headlineNews->content), 120) }}
                    </p>
                    <a href="{{ route('news.show', $headlineNews->slug) }}" style="color: #0191b3; font-weight: 600; font-size: 0.88rem; text-decoration: none;">Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
            @endif

            @foreach($recentNews as $news)
            <div style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; display: flex; flex-direction: column;">
                <img src="{{ $news->image_url }}" alt="{{ $news->title }}" style="width: 100%; height: 220px; object-fit: cover;">
                <div style="padding: 20px; flex: 1; display: flex; flex-direction: column;">
                    <span style="font-size: 0.8rem; color: #64748b; margin-bottom: 8px;"><i class="fa-regular fa-calendar"></i> {{ optional($news->published_at)->format('d M Y') ?? date('d M Y') }}</span>
                    <h3 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 10px;">
                        <a href="{{ route('news.show', $news->slug) }}" style="color: inherit; text-decoration: none;">{{ $news->title }}</a>
                    </h3>
                    <p style="font-size: 0.88rem; color: #64748b; line-height: 1.5; margin-bottom: 16px; flex: 1;">
                        {{ \Illuminate\Support\Str::limit(strip_tags($news->content), 120) }}
                    </p>
                    <a href="{{ route('news.show', $news->slug) }}" style="color: #0191b3; font-weight: 600; font-size: 0.88rem; text-decoration: none;">Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
