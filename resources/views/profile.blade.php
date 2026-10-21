@extends('layouts.app')

@section('title', 'Tentang Kami - PT Makmur Bersama Enjiniring')

@section('content')

<!-- PAGE BANNER -->
<section class="page-sub-banner">
    <div class="container">
        <h1 style="font-size: 2.2rem; font-weight: 800; color: #222;">Tentang Kami</h1>
    </div>
</section>

<!-- MAIN PROFILE CONTENT (MATCHING PAGE 2 PDF) -->
<section class="section-padding">
    <div class="container">
        <!-- 1. WORKSHOP PHOTO & COMPANY SUMMARY -->
        <div class="grid-2" style="margin-bottom: 60px;">
            <div>
                <img src="{{ asset('assets/images/page_profile/kalimas area depan.png') }}" alt="Gedung Workshop MBE" style="border-radius: var(--radius-md); box-shadow: var(--shadow-md); width: 100%;">
            </div>
            <div>
                <h2 style="font-size: 2.2rem; font-weight: 800; color: #222222; margin-bottom: 20px;">PT. MAKMUR BERSAMA ENJINIRING</h2>
                <p style="font-size: 1.05rem; line-height: 1.8; color: var(--text-dark);">
                    PT Makmur Bersama Enjiniring adalah perusahaan yang bergerak di bidang manufaktur, CNC Machining, Injection serta mekanikal industri dengan fokus memberikan solusi produksi yang berkualitas, presisi dan sesuai dengan kebutuhan pelanggan. Kami hadir sebagai mitra industri yang mengintegrasikan engineering, teknologi manufaktur, proses produksi dan quality control untuk menghasilkan produk serta komponen yang dapat mendukung berbagai sektor industri. Dengan mengedepankan ketepatan, kualitas, efisiensi, dan inovasi, kami berkomitmen untuk memberikan solusi yang tidak hanya memenuhi spesifikasi teknis, tetapi juga memberikan nilai tambah bagi pelanggan.
                </p>
            </div>
        </div>

        <!-- 2. JOURNEY TIMELINE GRAPHIC (PAGE 2 PDF) -->
        <div style="margin-bottom: 60px; text-align: center;">
            <img src="{{ asset('assets/images/page_profile/journey makben.png') }}" alt="Journey Makben Timeline" style="max-width: 900px; margin: 0 auto; width: 100%;" class="lightbox-trigger">
        </div>

        <!-- 3. VISI & MISI (PAGE 2 PDF) -->
        <div style="margin-bottom: 60px;">
            <div class="grid-2" style="align-items: start;">
                <div style="background: #ffffff; padding: 30px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border-top: 4px solid #0191b3; height: 100%;">
                    <h3 style="font-size: 1.6rem; font-weight: 800; color: #0191b3; margin-bottom: 16px; text-align: center;">Visi</h3>
                    <p style="font-size: 1.05rem; line-height: 1.7; color: var(--text-dark); text-align: center;">
                        Menjadi perusahaan terpercaya di industri manufaktur dan fabrikasi dengan sistem terintegrasi yang menghasilkan produk dan layanan secara efektif dan efisien, serta berkomitmen untuk tumbuh dan berkembang secara konsisten dengan memberikan pelayanan prima.
                    </p>
                </div>

                <div style="background: #ffffff; padding: 30px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border-top: 4px solid #222222; height: 100%;">
                    <h3 style="font-size: 1.6rem; font-weight: 800; color: #222222; margin-bottom: 16px; text-align: center;">Misi</h3>
                    <ul style="display: flex; flex-direction: column; gap: 12px; font-size: 0.98rem; color: var(--text-dark);">
                        <li style="display: flex; gap: 10px; align-items: flex-start;">
                            <i class="fa-solid fa-circle" style="color: #0191b3; font-size: 0.5rem; margin-top: 8px;"></i>
                            <span>Membangun dan menjaga kerja sama yang profesional, unggul, dan kompeten.</span>
                        </li>
                        <li style="display: flex; gap: 10px; align-items: flex-start;">
                            <i class="fa-solid fa-circle" style="color: #0191b3; font-size: 0.5rem; margin-top: 8px;"></i>
                            <span>Melakukan pengembangan berkelanjutan untuk meningkatkan optimalisasi kerja dan nilai pelayanan yang kompetitif dalam industri jasa fabrikasi.</span>
                        </li>
                        <li style="display: flex; gap: 10px; align-items: flex-start;">
                            <i class="fa-solid fa-circle" style="color: #0191b3; font-size: 0.5rem; margin-top: 8px;"></i>
                            <span>Mengutamakan pencapaian kualitas kerja yang sesuai dengan harapan dan kebutuhan mitra.</span>
                        </li>
                        <li style="display: flex; gap: 10px; align-items: flex-start;">
                            <i class="fa-solid fa-circle" style="color: #0191b3; font-size: 0.5rem; margin-top: 8px;"></i>
                            <span>Menjaga komitmen yang kuat terhadap ketepatan waktu pengiriman dan kualitas produk.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- 4. CORPORATE VALUE GRAPHIC (PAGE 2 PDF) -->
        <div style="margin-bottom: 60px; text-align: center;">
            <img src="{{ asset('assets/images/page_profile/corporate value.png') }}" alt="Corporate Values MBE" style="max-width: 1000px; margin: 0 auto; width: 100%; border-radius: 8px;" class="lightbox-trigger">
        </div>

        <!-- 5. TEAM PHOTO (PAGE 2 PDF) -->
        <div style="margin-bottom: 60px; text-align: center;">
            <img src="{{ asset('assets/images/page_profile/foto team.png') }}" alt="Foto Tim MBE" style="max-width: 900px; margin: 0 auto; width: 100%; border-radius: var(--radius-md); box-shadow: var(--shadow-md);" class="lightbox-trigger">
        </div>

        <!-- 6. WHY CHOOSE US (PAGE 2 PDF) -->
        <div style="text-align: center; max-width: 900px; margin: 0 auto;">
            <h2 style="font-size: 2.2rem; font-weight: 800; color: #222222; margin-bottom: 30px;">Why Choose Us</h2>
            <img src="{{ asset('assets/images/page_profile/why choose us.png') }}" alt="Why Choose Us MBE" style="width: 100%; border-radius: var(--radius-md);" class="lightbox-trigger">
        </div>
    </div>
</section>

@endsection
