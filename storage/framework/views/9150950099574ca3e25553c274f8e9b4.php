<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $__env->yieldContent('title', 'PT. Makmur Bersama Enjiniring'); ?> - Solusi Fabrikasi, Machining CNC & Industrial</title>
    
    <!-- Meta SEO -->
    <meta name="description" content="PT Makmur Bersama Enjiniring menghadirkan layanan profesional di bidang Fabrikasi, Machining CNC, Manufaktur, Extruder & Injeksi plastik, Laser cutting, Bending, Roll Plat & pipa.">
    <meta name="keywords" content="Makmur Bersama Enjiniring, MBE, Fabrikasi Cirebon, Machining CNC, Manufaktur, Laser Cutting, Bending, Piping, Ducting">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('assets/images/page_beranda/logo makben.png')); ?>">
    <link rel="shortcut icon" type="image/png" href="<?php echo e(asset('assets/images/page_beranda/logo makben.png')); ?>">

    <!-- FontAwesome & Google Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
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
            <a href="<?php echo e(route('home')); ?>" class="navbar-brand">
                <img src="<?php echo e(asset('assets/images/page_portoflio/logo makben.png')); ?>" alt="PT Makmur Bersama Enjiniring Logo">
            </a>

            <ul class="nav-menu" id="navMenu">
                <li><a href="<?php echo e(route('home')); ?>" class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">Beranda</a></li>
                <li><a href="<?php echo e(route('profile')); ?>" class="nav-link <?php echo e(request()->routeIs('profile') ? 'active' : ''); ?>">Tentang Kami</a></li>
                
                <!-- DYNAMIC PRODUK DROPDOWN WITH CUSTOM CATEGORY ICONS FROM DATABASE/CMS -->
                <li class="nav-item-dropdown">
                    <a href="<?php echo e(route('products.index')); ?>" class="nav-link <?php echo e(request()->routeIs('products.*') ? 'active' : ''); ?>">
                        Produk <i class="fa-solid fa-caret-down" style="font-size: 0.8rem;"></i>
                    </a>
                    <div class="dropdown-menu-custom" style="width: 280px; max-height: 420px; overflow-y: auto;">
                        <?php $__currentLoopData = $navCategories ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $navCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('products.show', $navCat->slug)); ?>" class="dropdown-item-custom <?php echo e(request()->is('produk/' . $navCat->slug) ? 'active' : ''); ?>">
                            <?php echo $navCat->icon_html; ?> <?php echo e($navCat->name); ?>

                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </li>

                <li><a href="<?php echo e(route('services')); ?>" class="nav-link <?php echo e(request()->routeIs('services') ? 'active' : ''); ?>">Layanan Kami</a></li>
                <li><a href="<?php echo e(route('portfolio')); ?>" class="nav-link <?php echo e(request()->routeIs('portfolio') ? 'active' : ''); ?>">Portofolio</a></li>
                <li><a href="<?php echo e(route('contact')); ?>" class="nav-link <?php echo e(request()->routeIs('contact') ? 'active' : ''); ?>">Hubungi Kami</a></li>
                <li><a href="<?php echo e(route('news.index')); ?>" class="nav-link <?php echo e(request()->routeIs('news.*') ? 'active' : ''); ?>">Berita</a></li>
            </ul>

            <div class="nav-actions">
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT VIEW -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
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
                    <img src="<?php echo e(asset('assets/images/page_portoflio/logo makben.png')); ?>" alt="Logo MAKBEEN">
                    <div class="footer-pdf-support">
                        <span>Support By</span>
                        <img src="<?php echo e(asset('assets/images/page_portoflio/logo baru kalimas.png')); ?>" alt="Support By KALIMAS CV KAWAN LINTAS MASA">
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
                <span>&copy; <?php echo e(date('Y')); ?> PT Makmur Bersama Enjiniring. All Rights Reserved.</span>
                <a href="<?php echo e(route('admin.login')); ?>" style="color: #888888; font-size: 0.75rem; opacity: 0.25; transition: all 0.3s; text-decoration: none; padding: 2px 6px;" onmouseover="this.style.opacity='1';this.style.color='#0191b3';" onmouseout="this.style.opacity='0.25';this.style.color='#888888';" title="System Management" target="_blank">
                    <i class="fa-solid fa-shield-halved" style="font-size: 0.7rem;"></i>
                </a>
            </div>
        </div>
    </footer>

    <script src="<?php echo e(asset('assets/js/main.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\compro-mbe\resources\views/layouts/app.blade.php ENDPATH**/ ?>