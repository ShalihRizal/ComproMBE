<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'PT. Makmur Bersama Enjiniring') - Solusi Fabrikasi, Machining CNC & Industrial</title>
    
    <!-- Meta SEO -->
    @hasSection('meta_description')
    <meta name="description" content="@yield('meta_description')">
    @else
    <meta name="description" content="PT Makmur Bersama Enjiniring menghadirkan layanan profesional di bidang Fabrikasi, Machining CNC, Manufaktur, Extruder & Injeksi plastik, Laser cutting, Bending, Roll Plat & pipa.">
    @endif
    <meta name="keywords" content="@yield('meta_keywords', 'Makmur Bersama Enjiniring, MBE, Fabrikasi Cirebon, Machining CNC, Manufaktur, Laser Cutting, Bending, Piping, Ducting')">
    <link rel="canonical" href="@yield('canonical_url', url()->current())">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('canonical_url', url()->current())">
    <meta property="og:title" content="@yield('og_title', 'PT. Makmur Bersama Enjiniring')">
    <meta property="og:description" content="@yield('meta_description', 'PT Makmur Bersama Enjiniring menghadirkan layanan profesional di bidang Fabrikasi, Machining CNC, Manufaktur, Extruder & Injeksi plastik, Laser cutting, Bending, Roll Plat & pipa.')">
    <meta property="og:image" content="@yield('og_image', asset('assets/images/page_beranda/logo makben.png'))">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="@yield('canonical_url', url()->current())">
    <meta name="twitter:title" content="@yield('og_title', 'PT. Makmur Bersama Enjiniring')">
    <meta name="twitter:description" content="@yield('meta_description', 'PT Makmur Bersama Enjiniring menghadirkan layanan profesional di bidang Fabrikasi, Machining CNC, Manufaktur, Extruder & Injeksi plastik, Laser cutting, Bending, Roll Plat & pipa.')">
    <meta name="twitter:image" content="@yield('og_image', asset('assets/images/page_beranda/logo makben.png'))">

    @stack('schema')
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/page_beranda/logo makben.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/page_beranda/logo makben.png') }}">

    <!-- FontAwesome & Google Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @stack('styles')
</head>
<body>

    <!-- TOP BLUE INFO BAR (#0191b3) -->
    <div class="top-info-bar">
        <div class="container">
            <div class="top-info-left">
                <div class="top-info-item">
                    <i class="fa-solid fa-phone"></i>
                    <a href="tel:082227666909" style="color: white;">082227666909</a>
                </div>
                <div class="top-info-item">
                    <i class="fa-solid fa-envelope"></i>
                    <a href="mailto:marketing@makben.co.id" style="color: white;">marketing@makben.co.id</a>
                </div>
            </div>
            <div class="top-info-right">
                <div class="social-links">
                    <span style="font-size: 0.85rem; opacity: 0.95; margin-right: 4px;">Media Sosial :</span>
                    <a href="https://www.instagram.com/makben.official" target="_blank" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://www.facebook.com/MakbenMakmur" target="_blank" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://youtube.com/@makbenofficial?si=QIbyObDl-Dr3J6pW" target="_blank" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
                    <a href="https://www.tiktok.com/@makben.official" target="_blank" title="TikTok"><i class="fa-brands fa-tiktok"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN NAVBAR -->
    <nav class="main-navbar">
        <div class="container navbar-container">
            <a href="{{ route('home') }}" class="navbar-brand">
                <img src="{{ asset('assets/images/page_portoflio/logo makben.png') }}" alt="PT Makmur Bersama Enjiniring Logo">
            </a>

            <ul class="nav-menu" id="navMenu">
                <li><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
                <li><a href="{{ route('profile') }}" class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">Tentang Kami</a></li>
                
                <!-- DYNAMIC PRODUK DROPDOWN WITH CUSTOM CATEGORY ICONS FROM DATABASE/CMS -->
                <li class="nav-item-dropdown">
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        Produk <i class="fa-solid fa-caret-down" style="font-size: 0.8rem;"></i>
                    </a>
                    <div class="dropdown-menu-custom" style="width: 280px; max-height: 420px; overflow-y: auto;">
                        @foreach($navCategories ?? [] as $navCat)
                        <a href="{{ route('products.show', $navCat->slug) }}" class="dropdown-item-custom {{ request()->is('produk/' . $navCat->slug) ? 'active' : '' }}">
                            {!! $navCat->icon_html !!} {{ $navCat->name }}
                        </a>
                        @endforeach
                    </div>
                </li>

                <li><a href="{{ route('services') }}" class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}">Layanan Kami</a></li>
                <li><a href="{{ route('portfolio') }}" class="nav-link {{ request()->routeIs('portfolio') ? 'active' : '' }}">Portofolio</a></li>
                <li><a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Hubungi Kami</a></li>
                <li><a href="{{ route('news.index') }}" class="nav-link {{ request()->routeIs('news.*') ? 'active' : '' }}">Berita</a></li>
            </ul>

            <div class="nav-actions">
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT VIEW -->
    <main>
        @yield('content')
    </main>

    <!-- FLOATING WHATSAPP BUTTON (MATCHING PDF) -->
    <a href="https://wa.me/6282227666909?text=Halo%20PT%20Makmur%20Bersama%20Enjiniring" target="_blank" class="whatsapp-float" title="Hubungi kami via WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

    <!-- PDF LIGHT GRAY FOOTER (EXACT PDF MATCH) -->
    <footer class="footer-pdf">
        <div class="container">
            <div class="footer-pdf-grid">
                
                <!-- BRAND & SUPPORT LOGO -->
                <div class="footer-pdf-brand">
                    <img src="{{ asset('assets/images/page_portoflio/logo makben.png') }}" alt="Logo MAKBEEN">
                    <div class="footer-pdf-support">
                        <span>Support By</span>
                        <img src="{{ asset('assets/images/page_portoflio/logo baru kalimas.png') }}" alt="Support By KALIMAS CV KAWAN LINTAS MASA">
                    </div>
                </div>

                <!-- CONTACT & ORDER INFO -->
                <div>
                    <h4 class="footer-pdf-title">Hubungi Kami</h4>
                    
                    <div class="footer-pdf-item">
                        <div class="footer-pdf-label">Informasi Pemesanan :</div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-envelope" style="color: #ea4335;"></i>
                            <a href="mailto:marketing@makben.co.id" style="color: #333; font-weight: 500;">marketing@makben.co.id</a>
                        </div>
                    </div>

                    <div class="footer-pdf-item" style="margin-top: 14px;">
                        <div class="footer-pdf-label">Informasi Lainnya :</div>
                        <div style="display: flex; align-items: center; gap: 12px; font-size: 1.2rem; margin-top: 4px;">
                            <a href="https://youtube.com/@makbenofficial?si=QIbyObDl-Dr3J6pW" target="_blank" style="color: #ff0000;" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
                            <a href="https://www.facebook.com/MakbenMakmur" target="_blank" style="color: #1877f2;" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="https://www.instagram.com/makben.official" target="_blank" style="color: #e4405f;" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                            <a href="https://www.tiktok.com/@makben.official" target="_blank" style="color: #000000;" title="TikTok"><i class="fa-brands fa-tiktok"></i></a>
                        </div>
                    </div>
                </div>

                <!-- PHONE & ADDRESS INFO -->
                <div>
                    <div class="footer-pdf-item">
                        <div class="footer-pdf-label">Kontak Kami :</div>
                        <div style="display: flex; flex-direction: column; gap: 6px; margin-top: 4px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fa-solid fa-phone" style="color: #25d366;"></i>
                                <a href="tel:0231201520" style="color: #333;">(0231) 201520</a>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fa-solid fa-phone" style="color: #25d366;"></i>
                                <a href="tel:082227666909" style="color: #333;">0822 2766 6909</a>
                            </div>
                        </div>
                    </div>

                    <div class="footer-pdf-item" style="margin-top: 16px;">
                        <div class="footer-pdf-label">Alamat Kami :</div>
                        <p style="font-size: 0.88rem; color: #555; line-height: 1.5; margin-top: 4px;">
                            Workshop : Jl. Kalijaga No 162 Pegambiran, Kec. Lemahwungkuk, Kota Cirebon Jawa Barat 45113
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <!-- SUBTLE BOTTOM FOOTER WITH HIDDEN CMS LOGIN LINK -->
        <div style="background-color: #dcdfe3; padding: 10px 0; border-top: 1px solid #d0d4d9; font-size: 0.8rem; color: #666; margin-top: 30px;">
            <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
                <span>&copy; {{ date('Y') }} PT Makmur Bersama Enjiniring. All Rights Reserved.</span>
                <a href="{{ route('admin.login') }}" style="color: #888888; font-size: 0.75rem; opacity: 0.25; transition: all 0.3s; text-decoration: none; padding: 2px 6px;" onmouseover="this.style.opacity='1';this.style.color='#0191b3';" onmouseout="this.style.opacity='0.25';this.style.color='#888888';" title="System Management" target="_blank">
                    <i class="fa-solid fa-shield-halved" style="font-size: 0.7rem;"></i>
                </a>
            </div>
        </div>
    </footer>

    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>
