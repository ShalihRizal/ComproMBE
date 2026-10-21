<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CMS Admin') - PT Makmur Bersama Enjiniring</title>

    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --bs-body-font-family: 'Plus Jakarta Sans', sans-serif;
            --mbe-primary: #0191b3;
            --mbe-dark: #0f172a;
            --mbe-bg: #f8fafc;
        }

        body {
            background-color: var(--mbe-bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #334155;
            min-height: 100vh;
        }

        .navbar-admin {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .sidebar-admin {
            width: 260px;
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            min-height: calc(100vh - 65px);
            padding: 24px 16px;
        }

        .sidebar-heading {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            padding: 12px 16px 6px;
        }

        .nav-link-admin {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            border-radius: 12px;
            color: #64748b;
            font-weight: 600;
            font-size: 0.92rem;
            text-decoration: none;
            transition: all 0.2s ease;
            margin-bottom: 4px;
        }

        .nav-link-admin:hover {
            color: var(--mbe-primary);
            background-color: #f0f9ff;
        }

        .nav-link-admin.active {
            color: #ffffff;
            background-color: var(--mbe-primary);
            box-shadow: 0 4px 12px rgba(1, 145, 179, 0.25);
        }

        .content-admin {
            flex: 1;
            padding: 30px;
        }

        .card-custom {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        }

        .btn-mbe {
            background-color: var(--mbe-primary);
            color: #ffffff;
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-mbe:hover {
            background-color: #017a96;
            color: #ffffff;
            transform: translateY(-1px);
        }

        .btn-mbe-outline {
            background-color: transparent;
            color: var(--mbe-primary);
            border: 1.5px solid var(--mbe-primary);
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .btn-mbe-outline:hover {
            background-color: var(--mbe-primary);
            color: #ffffff;
        }

        /* SVG Pagination Fix */
        nav[role="navigation"] svg, .pagination svg {
            width: 14px !important;
            height: 14px !important;
            max-width: 14px !important;
            max-height: 14px !important;
            fill: currentColor;
            display: inline-block;
            vertical-align: middle;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- TOP NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-admin sticky-top">
        <div class="container-fluid px-3">
            
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-lg-none border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                    <i class="fa-solid fa-bars fs-5"></i>
                </button>
                <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-dark m-0" href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('assets/images/page_portoflio/logo makben.png') }}" alt="MBE Logo" height="36">
                    <span class="fs-6 fw-bold text-secondary d-none d-sm-inline">| CMS Admin Panel</span>
                </a>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-mbe-outline d-none d-sm-inline-flex align-items-center gap-2">
                    <i class="fa-solid fa-globe"></i> Lihat Website
                </a>
                
                <div class="dropdown">
                    <button class="btn btn-light border-0 dropdown-toggle d-flex align-items-center gap-2 py-1 px-3 rounded-pill bg-white border" type="button" data-bs-toggle="dropdown">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.85rem; font-weight: 700;">
                            {{ strtoupper(substr(session('admin_name', 'A'), 0, 1)) }}
                        </div>
                        <span class="fw-semibold text-dark fs-7 d-none d-md-inline">{{ session('admin_name', 'Admin MBE') }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-2">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('home') }}" target="_blank">
                                <i class="fa-solid fa-globe text-muted"></i> Lihat Website Publik
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2 py-2">
                                    <i class="fa-solid fa-right-from-bracket"></i> Keluar (Logout)
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </nav>

    <div class="d-flex">
        
        <!-- DESKTOP SIDEBAR -->
        <aside class="sidebar-admin d-none d-lg-block">
            <div class="sidebar-heading">CMS Berita</div>
            <a href="{{ route('admin.news.index') }}" class="nav-link-admin {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                <i class="fa-solid fa-newspaper fs-6"></i> Kelola Berita
            </a>

            <div class="sidebar-heading mt-3">Master Produk</div>
            <a href="{{ route('admin.product-categories.index') }}" class="nav-link-admin {{ request()->routeIs('admin.product-categories.*') ? 'active' : '' }}">
                <i class="fa-solid fa-layer-group fs-6"></i> Kategori Produk
            </a>
            <a href="{{ route('admin.products.index') }}" class="nav-link-admin {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fa-solid fa-boxes-stacked fs-6"></i> Master Produk
            </a>
        </aside>

        <!-- MOBILE OFFCANVAS SIDEBAR -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title fw-bold">Menu CMS Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body p-3">
                <div class="sidebar-heading">CMS Berita</div>
                <a href="{{ route('admin.news.index') }}" class="nav-link-admin {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-newspaper fs-6"></i> Kelola Berita
                </a>

                <div class="sidebar-heading mt-3">Master Produk</div>
                <a href="{{ route('admin.product-categories.index') }}" class="nav-link-admin {{ request()->routeIs('admin.product-categories.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-layer-group fs-6"></i> Kategori Produk
                </a>
                <a href="{{ route('admin.products.index') }}" class="nav-link-admin {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-boxes-stacked fs-6"></i> Master Produk
                </a>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <main class="content-admin">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="fa-solid fa-circle-check fs-5"></i>
                <div class="fw-semibold">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @yield('content')
        </main>

    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
