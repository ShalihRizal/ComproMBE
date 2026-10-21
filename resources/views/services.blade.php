@extends('layouts.app')

@section('title', 'Layanan Kami - PT Makmur Bersama Enjiniring')

@push('styles')
<style>
    .service-block-item {
        scroll-margin-top: 100px;
        padding: 24px;
        border-radius: 20px;
        transition: all 0.4s ease;
    }

    .service-block-item.highlight-service {
        background-color: #f0f9ff;
        border: 2px solid #0191b3;
        box-shadow: 0 10px 30px rgba(1, 145, 179, 0.15);
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
            <h1 class="pdf-section-title">Layanan Kami</h1>
        </div>
    </div>
</section>

<!-- SERVICES DETAIL SECTION (MATCHING PAGE 3 PDF) -->
<section class="section-padding" style="background: #ffffff;">
    <div class="container">
        <div style="display: flex; flex-direction: column; gap: 50px;">
            
            <!-- 1. ROLLING -->
            <div class="grid-2 service-block-item" id="rolling">
                <div style="text-align: center; padding: 20px;">
                    <img src="{{ asset('assets/images/page_layanan_kami/icon rol plat.png') }}" alt="Icon Rolling" style="width: 50px; height: 50px; margin: 0 auto 12px;">
                    <h3 style="font-size: 1.6rem; font-weight: 800; color: #222222; margin-bottom: 14px;">ROLLING</h3>
                    <p style="font-size: 1rem; line-height: 1.7; color: var(--text-dark); text-align: justify;">
                        Kami menyediakan layanan Rolling untuk membentuk plat dan material logam menjadi silinder, lengkung, atau pipa sesuai kebutuhan proyek. Dengan mesin Plate Rolling berkapasitas tinggi dan operator berpengalaman, hasil pengerjaan dijamin presisi, rapi, dan konsisten tanpa merusak struktur material.
                    </p>
                </div>
                <div>
                    <img src="{{ asset('assets/images/page_layanan_kami/layanan kami rol plat.png') }}" alt="Layanan Rolling Plat & Pipa MBE" style="width: 100%; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);" class="lightbox-trigger">
                </div>
            </div>

            <!-- 2. BENDING -->
            <div class="grid-2 service-block-item" id="bending">
                <div>
                    <img src="{{ asset('assets/images/page_layanan_kami/layanan kami bending.png') }}" alt="Layanan Bending Plat Logam MBE" style="width: 100%; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);" class="lightbox-trigger">
                </div>
                <div style="text-align: center; padding: 20px;">
                    <img src="{{ asset('assets/images/page_layanan_kami/icon bending.png') }}" alt="Icon Bending" style="width: 50px; height: 50px; margin: 0 auto 12px;">
                    <h3 style="font-size: 1.6rem; font-weight: 800; color: #222222; margin-bottom: 14px;">BENDING</h3>
                    <p style="font-size: 1rem; line-height: 1.7; color: var(--text-dark); text-align: justify;">
                        Layanan Bending kami menggunakan mesin Press Brake berteknologi tinggi untuk menekuk plat logam dengan akurasi sudut dan dimensi yang presisi. Proses bending dilakukan dengan kontrol ketat agar hasil sesuai dengan desain dan kebutuhan fabrikasi Anda.
                    </p>
                </div>
            </div>

            <!-- 3. WELDING -->
            <div class="grid-2 service-block-item" id="welding">
                <div style="text-align: center; padding: 20px;">
                    <img src="{{ asset('assets/images/page_layanan_kami/icon welding.png') }}" alt="Icon Welding" style="width: 50px; height: 50px; margin: 0 auto 12px;">
                    <h3 style="font-size: 1.6rem; font-weight: 800; color: #222222; margin-bottom: 14px;">WELDING</h3>
                    <p style="font-size: 1rem; line-height: 1.7; color: var(--text-dark); text-align: justify;">
                        Kami melayani berbagai jenis pengelasan logam dengan hasil kuat, rapi, dan tahan lama. Dengan tenaga las profesional dan peralatan lengkap, kami siap menangani kebutuhan fabrikasi, perakitan, maupun perbaikan.
                    </p>
                </div>
                <div>
                    <img src="{{ asset('assets/images/page_layanan_kami/layanan kami welding.png') }}" alt="Layanan Pengelasan Welding MBE" style="width: 100%; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);" class="lightbox-trigger">
                </div>
            </div>

            <!-- 4. LASER CUTTING -->
            <div class="grid-2 service-block-item" id="laser-cutting">
                <div>
                    <img src="{{ asset('assets/images/page_layanan_kami/layanan kami fiber laser cutting.png') }}" alt="Layanan Laser Cutting MBE" style="width: 100%; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);" class="lightbox-trigger">
                </div>
                <div style="text-align: center; padding: 20px;">
                    <img src="{{ asset('assets/images/page_layanan_kami/icon laser cutting.png') }}" alt="Icon Laser Cutting" style="width: 50px; height: 50px; margin: 0 auto 12px;">
                    <h3 style="font-size: 1.6rem; font-weight: 800; color: #222222; margin-bottom: 14px;">LASER CUTTING</h3>
                    <p style="font-size: 1rem; line-height: 1.7; color: var(--text-dark); text-align: justify;">
                        Teknologi Laser Cutting kami mampu memotong plat logam dengan presisi tinggi dan hasil potongan halus tanpa proses finishing tambahan. Prosesnya cepat, efisien, dan ideal untuk produksi pola rumit, huruf, logo, maupun komponen industri.
                    </p>
                </div>
            </div>

            <!-- 5. DUCTING -->
            <div class="grid-2 service-block-item" id="ducting">
                <div style="text-align: center; padding: 20px;">
                    <img src="{{ asset('assets/images/page_layanan_kami/icon ducting.png') }}" alt="Icon Ducting" style="width: 50px; height: 50px; margin: 0 auto 12px;">
                    <h3 style="font-size: 1.6rem; font-weight: 800; color: #222222; margin-bottom: 14px;">DUCTING</h3>
                    <p style="font-size: 1rem; line-height: 1.7; color: var(--text-dark); text-align: justify;">
                        Layanan pembuatan dan instalasi sistem ducting dirancang untuk memenuhi kebutuhan sirkulasi udara, ventilasi, serta pembuangan udara panas, asap, dan debu pada berbagai sektor mulai dari gedung komersial, fasilitas industri, hingga dapur profesional. Dengan dukungan tenaga ahli berpengalaman dan peralatan fabrikasi modern, setiap sistem ducting dikerjakan dengan presisi tinggi serta efisiensi aliran udara yang optimal.
                    </p>
                </div>
                <div>
                    <img src="{{ asset('assets/images/page_layanan_kami/layanan kami ducting.png') }}" alt="Layanan Ducting System MBE" style="width: 100%; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);" class="lightbox-trigger">
                </div>
            </div>

            <!-- 6. PIPING -->
            <div class="grid-2 service-block-item" id="piping">
                <div>
                    <img src="{{ asset('assets/images/page_layanan_kami/layanan kami piping.png') }}" alt="Layanan Gas Piping System MBE" style="width: 100%; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);" class="lightbox-trigger">
                </div>
                <div style="text-align: center; padding: 20px;">
                    <img src="{{ asset('assets/images/page_layanan_kami/icon piping.png') }}" alt="Icon Piping" style="width: 50px; height: 50px; margin: 0 auto 12px;">
                    <h3 style="font-size: 1.6rem; font-weight: 800; color: #222222; margin-bottom: 14px;">PIPING</h3>
                    <p style="font-size: 1rem; line-height: 1.7; color: var(--text-dark); text-align: justify;">
                        Kami menyediakan layanan Instalasi Pipa Gas atau yang sering disebut Gas Piping, gas piping adalah sistem perpipaan yang dirancang khusus untuk mengalirkan gas alam, LPG, atau jenis gas lainnya dari sumber suplai (seperti tangki penyimpanan atau jaringan distribusi utama) ke titik-titik konsumsi (seperti kompor, pemanas, boiler, atau peralatan industri).
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hash = window.location.hash;
        if (hash) {
            const targetElement = document.querySelector(hash);
            if (targetElement) {
                setTimeout(() => {
                    targetElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    targetElement.classList.add('highlight-service');
                    setTimeout(() => {
                        targetElement.classList.remove('highlight-service');
                    }, 2500);
                }, 200);
            }
        }
    });
</script>
@endpush

@endsection
