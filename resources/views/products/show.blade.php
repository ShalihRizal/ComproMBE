@extends('layouts.app')

@section('title', $category->name . ' - PT Makmur Bersama Enjiniring')

@push('styles')
<style>
    /* PRODUCT TEMPLATE EXACT MATCHING PDF DESIGN */
    .product-hero-container {
        display: grid;
        grid-template-columns: 1fr 1.1fr;
        gap: 40px;
        align-items: center;
        margin-bottom: 50px;
    }

    .product-cyan-box {
        background-color: #bceaf0;
        border-radius: 24px;
        padding: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 360px;
        box-shadow: 0 10px 25px rgba(188, 234, 240, 0.4);
        overflow: hidden;
        cursor: pointer;
    }

    .product-cyan-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 16px;
        transition: transform 0.3s ease;
    }

    .product-cyan-box:hover img {
        transform: scale(1.05);
    }

    .product-details-content h1 {
        font-size: 2.2rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 16px;
        line-height: 1.2;
    }

    .product-details-content p {
        font-size: 0.95rem;
        line-height: 1.75;
        color: #475569;
        margin-bottom: 24px;
        text-align: justify;
    }

    .product-subheading {
        font-size: 1.6rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .product-subheading::before {
        content: '';
        display: inline-block;
        width: 6px;
        height: 24px;
        background-color: #0191b3;
        border-radius: 4px;
    }

    /* 4 COLUMN PRODUCT CARDS GRID */
    .product-items-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px 16px;
        margin-bottom: 60px;
    }

    .product-item-card {
        display: flex;
        align-items: center;
        gap: 14px;
        background: #ffffff;
        padding: 10px;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        transition: all 0.25s ease;
        text-decoration: none;
        color: inherit;
        cursor: pointer;
    }

    .product-item-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        border-color: #0191b3;
    }

    .product-thumb-box {
        width: 155px;
        height: 100px;
        flex-shrink: 0;
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .product-thumb-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transform: scale(1.45);
        transform-origin: center;
        display: block;
        transition: transform 0.3s ease;
    }

    .product-item-card:hover .product-thumb-box img {
        transform: scale(1.65);
    }

    .product-item-info {
        display: flex;
        flex-direction: column;
        justify-content: center;
        flex-grow: 1;
    }

    .product-item-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.35;
        margin-bottom: 4px;
    }

    .product-item-specs {
        font-size: 0.78rem;
        color: #64748b;
        font-weight: 500;
    }

    @media (max-width: 1024px) {
        .product-items-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .product-hero-container {
            grid-template-columns: 1fr;
            gap: 24px;
        }

        .product-cyan-box {
            height: 280px;
        }

        .product-items-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .product-thumb-box {
            width: 130px;
            height: 90px;
        }
    }

    @media (max-width: 480px) {
        .product-items-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

<!-- PAGE BANNER -->
<section class="page-banner">
    <div class="container">
        <h1>{{ $category->name }}</h1>
        <div class="breadcrumb-custom">
            <a href="{{ route('home') }}">Beranda</a>
            <i class="fa-solid fa-angle-right" style="font-size: 0.75rem;"></i>
            <a href="{{ route('products.index') }}">Produk Kami</a>
            <i class="fa-solid fa-angle-right" style="font-size: 0.75rem;"></i>
            <span>{{ $category->name }}</span>
        </div>
    </div>
</section>

<section class="section-padding" style="background: #ffffff;">
    <div class="container">

        <!-- TOP HERO SECTION (CYAN CARD LEFT + DESCRIPTION RIGHT) -->
        <div class="product-hero-container">
            <div class="product-cyan-box lightbox-trigger" data-src="{{ $category->header_image_url }}" title="Klik untuk melihat gambar besar">
                <img src="{{ $category->header_image_url }}" alt="{{ $category->name }}">
            </div>

            <div class="product-details-content">
                <h1>{{ $category->name }}</h1>
                <p>{{ $category->description }}</p>
                <div style="display: flex; gap: 14px; flex-wrap: wrap;">
                    <a href="https://wa.me/6282227666909?text=Halo%20PT%20Makmur%20Bersama%20Enjiniring,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($category->name) }}" target="_blank" class="btn-pill btn-pill-green">
                        <i class="fa-brands fa-whatsapp"></i> Hubungi Kami
                    </a>
                    <a href="{{ route('contact') }}" class="btn-pill btn-pill-primary">
                        Minta Penawaran
                    </a>
                </div>
            </div>
        </div>

        <!-- PRODUCT SUB-HEADING (e.g. Profile PVC) -->
        <h2 class="product-subheading">{{ $category->category_name ?? $category->name }}</h2>

        <!-- 4-COLUMN PRODUCT CARDS GRID (CLICK TO VIEW FULL RESOLUTION MODAL) -->
        <div class="product-items-grid">
            @foreach($category->products as $item)
            <div class="product-item-card lightbox-trigger" data-src="{{ $item->image_url }}" title="Klik untuk melihat gambar besar & zoom">
                <div class="product-thumb-box">
                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
                </div>
                <div class="product-item-info">
                    <div class="product-item-title">{{ $item->name }}</div>
                    <div class="product-item-specs">{{ $item->specs }}</div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

@endsection
