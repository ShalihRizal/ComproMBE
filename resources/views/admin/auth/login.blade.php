<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin CMS - PT Makmur Bersama Enjiniring</title>

    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #0191b3 100%);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card-login {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 440px;
            padding: 44px 36px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-mbe {
            background-color: #0191b3;
            color: #ffffff;
            border-radius: 50px;
            padding: 12px 24px;
            font-weight: 700;
            font-size: 0.95rem;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-mbe:hover {
            background-color: #017a96;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(1, 145, 179, 0.35);
        }
    </style>
</head>
<body>

    <div class="card-login text-center">
        <div class="mb-4">
            <img src="{{ asset('assets/images/page_portoflio/logo makben.png') }}" alt="Logo MBE" height="54">
        </div>
        
        <h4 class="fw-bold text-dark mb-1">CMS Admin Login</h4>
        <p class="text-secondary small mb-4">Kelola Katalog Produk, Berita & SEO PT Makmur Bersama Enjiniring</p>

        @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-3 text-start small mb-4" role="alert">
            <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="text-start">
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-bold small text-dark" for="email">EMAIL ADMIN</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0 rounded-start-3"><i class="fa-regular fa-envelope"></i></span>
                    <input type="email" name="email" id="email" class="form-control bg-light border-start-0 rounded-end-3 py-2" value="{{ old('email', 'admin@makben.co.id') }}" required placeholder="admin@makben.co.id">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold small text-dark" for="password">PASSWORD</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0 rounded-start-3"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control bg-light border-start-0 rounded-end-3 py-2" value="password123" required placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="btn btn-mbe w-100 py-3">
                <i class="fa-solid fa-right-to-bracket me-2"></i> Masuk ke CMS
            </button>
        </form>

        <div class="mt-4 pt-2 border-top">
            <a href="{{ route('home') }}" class="text-decoration-none small text-muted hover-primary">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Beranda Utama
            </a>
        </div>
    </div>

</body>
</html>
