@extends('layouts.app')

@section('title', 'Portofolio - PT Makmur Bersama Enjiniring')

@push('styles')
<style>
    /* BENTO GRID 3X3 PORTFOLIO STYLING */
    .portfolio-bento-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 60px;
    }

    .portfolio-card {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        background: #0f172a;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        cursor: pointer;
        transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        min-height: 260px;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
    }

    .portfolio-card.featured {
        grid-column: span 2;
        grid-row: span 2;
        min-height: 540px;
    }

    .portfolio-card-img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease, filter 0.3s ease;
        filter: brightness(0.92);
    }

    .portfolio-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.18);
    }

    .portfolio-card:hover .portfolio-card-img {
        transform: scale(1.06);
        filter: brightness(0.85);
    }

    .portfolio-card-overlay {
        position: relative;
        z-index: 2;
        padding: 24px;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0) 0%, rgba(15, 23, 42, 0.92) 80%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        height: 100%;
        transition: padding 0.3s ease;
    }

    .portfolio-card.featured .portfolio-card-overlay {
        padding: 36px;
    }

    .portfolio-badge {
        display: inline-block;
        align-self: flex-start;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.76rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
        background: rgba(1, 145, 179, 0.9);
        color: #ffffff;
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .portfolio-badge.featured-badge {
        background: #0191b3;
        box-shadow: 0 4px 14px rgba(1, 145, 179, 0.4);
    }

    .portfolio-title {
        color: #ffffff;
        font-weight: 800;
        font-size: 1.15rem;
        line-height: 1.35;
        margin-bottom: 6px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
    }

    .portfolio-card.featured .portfolio-title {
        font-size: 1.85rem;
        margin-bottom: 10px;
    }

    .portfolio-desc {
        color: #cbd5e1;
        font-size: 0.85rem;
        line-height: 1.5;
        opacity: 0.9;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .portfolio-card.featured .portfolio-desc {
        font-size: 1rem;
        -webkit-line-clamp: 3;
    }

    .portfolio-hover-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 1rem;
        opacity: 0;
        transform: scale(0.8);
        transition: all 0.3s ease;
        z-index: 3;
    }

    .portfolio-card:hover .portfolio-hover-icon {
        opacity: 1;
        transform: scale(1);
    }

    /* FILTER TABS */
    .filter-tabs {
        display: flex;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 40px;
    }

    .filter-btn {
        padding: 10px 22px;
        border-radius: 50px;
        font-size: 0.88rem;
        font-weight: 600;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: #0191b3;
        color: #ffffff;
        border-color: #0191b3;
        box-shadow: 0 4px 14px rgba(1, 145, 179, 0.25);
    }

    @media (max-width: 1024px) {
        .portfolio-bento-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .portfolio-card.featured {
            grid-column: span 2;
            min-height: 420px;
        }
    }

    @media (max-width: 640px) {
        .portfolio-bento-grid {
            grid-template-columns: 1fr;
        }

        .portfolio-card.featured {
            grid-column: span 1;
            grid-row: span 1;
            min-height: 300px;
        }

        .portfolio-card.featured .portfolio-title {
            font-size: 1.3rem;
        }
    }
</style>
@endpush

@section('content')

<!-- PAGE BANNER -->
<section class="page-banner">
    <div class="container">
        <h1>Portofolio & Dokumentasi Proyek</h1>
        <div class="breadcrumb-custom">
            <a href="{{ route('home') }}">Beranda</a>
            <i class="fa-solid fa-angle-right" style="font-size: 0.75rem;"></i>
            <span>Portofolio</span>
        </div>
    </div>
</section>

<!-- PORTOFOLIO BENTO GRID SECTION -->
<section class="section-padding" style="background: #ffffff;">
    <div class="container">
        
        <div class="section-header text-center" style="max-width: 750px; margin: 0 auto 40px;">
            <h2 class="section-title">Hasil Pengerjaan & Dokumentasi Workshop</h2>
            <div class="section-title-line">
                <span></span><i class="fa-solid fa-briefcase"></i><span></span>
            </div>
            <p class="section-subtitle">Tampilan dokumentasi pengerjaan fabrikasi, machining presisi, perakitan mesin, dan instalasi industri PT Makmur Bersama Enjiniring.</p>
        </div>

        <!-- CATEGORY FILTER BUTTONS -->
        <div class="filter-tabs">
            <button class="filter-btn active" data-filter="all">Semua Proyek</button>
            <button class="filter-btn" data-filter="manufaktur">Manufaktur</button>
            <button class="filter-btn" data-filter="fabrikasi">Fabrikasi Logam</button>
            <button class="filter-btn" data-filter="machining">Machining CNC</button>
            <button class="filter-btn" data-filter="piping">Piping & System</button>
            <button class="filter-btn" data-filter="trading">Trading Material</button>
        </div>

        <!-- BENTO GRID (1 UTAMA BESAR 2X2 + 8 KARTU PRESET 3X3) -->
        <div class="portfolio-bento-grid" id="portfolioGrid">
            @foreach($portfolioItems as $item)
            <div class="portfolio-card {{ $item['featured'] ? 'featured' : '' }} lightbox-trigger" data-category="{{ $item['category'] }}" data-src="{{ asset('assets/images/page_portoflio/' . $item['image']) }}" title="Klik untuk melihat gambaran penuh">
                <img src="{{ asset('assets/images/page_portoflio/' . $item['image']) }}" alt="{{ $item['title'] }}" class="portfolio-card-img">
                
                <div class="portfolio-hover-icon">
                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                </div>

                <div class="portfolio-card-overlay">
                    <span class="portfolio-badge {{ $item['featured'] ? 'featured-badge' : '' }}">
                        {{ $item['featured'] ? '★ PROYEK UNGGULAN' : $item['category_name'] }}
                    </span>
                    <h3 class="portfolio-title">{{ $item['title'] }}</h3>
                    <p class="portfolio-desc">{{ $item['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- JANGKAUAN & MITRA SECTION -->
        <div style="margin-top: 50px; background: #0f172a; color: #ffffff; padding: 50px; border-radius: 24px; box-shadow: 0 15px 35px rgba(15,23,42,0.15);">
            <div class="grid-2" style="align-items: center; gap: 40px;">
                <div>
                    <span style="color: #0191b3; font-weight: 700; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">COVERAGE INDONESIA</span>
                    <h3 style="font-size: 2.1rem; font-weight: 800; margin: 10px 0 16px; color: #ffffff;">Jangkauan Layanan Nasional</h3>
                    <p style="color: #94a3b8; line-height: 1.7; font-size: 0.98rem;">
                        Dengan dukungan armada pengiriman serta jaringan logistik yang solid, produk manufaktur dan fabrikasi kami siap dikirim ke seluruh kawasan industri di Indonesia dengan jaminan kepatuhan jadwal.
                    </p>
                    <div style="display: flex; align-items: center; gap: 20px; background: rgba(255,255,255,0.06); padding: 18px 24px; border-radius: 16px; margin-top: 24px; border: 1px solid rgba(255,255,255,0.1);">
                        <img src="{{ asset('assets/images/page_portoflio/logo baru kalimas.png') }}" alt="Logo Kalimas Group" style="height: 52px; object-fit: contain;">
                        <div>
                            <p style="font-weight: 700; margin-bottom: 2px; color: #ffffff;">Mitra Strategis Kalimas Group</p>
                            <p style="font-size: 0.85rem; color: #cbd5e1; margin-bottom: 0;">Pengadaan & fabrikasi manufaktur terpadu</p>
                        </div>
                    </div>
                </div>
                <div style="text-align: center;">
                    <img src="{{ asset('assets/images/page_portoflio/map indonesia icon.png') }}" alt="Map Indonesia MBE" style="max-height: 290px; margin: 0 auto; filter: drop-shadow(0 10px 25px rgba(0,0,0,0.5));">
                </div>
            </div>
        </div>

    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const portfolioCards = document.querySelectorAll('.portfolio-card');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');

                portfolioCards.forEach(card => {
                    const category = card.getAttribute('data-category');
                    if (filter === 'all' || category === filter) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endpush

@endsection
