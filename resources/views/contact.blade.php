@extends('layouts.app')

@section('title', 'Hubungi Kami - PT Makmur Bersama Enjiniring')

@push('styles')
<style>
    .form-control-custom {
        width: 100% !important;
        box-sizing: border-box !important;
        background-color: #f0f2f5;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 16px 20px;
        font-size: 0.95rem;
        font-weight: 600;
        color: #333333;
        outline: none;
        transition: all 0.25s ease;
    }

    .form-control-custom:focus {
        background-color: #ffffff;
        border-color: #0191b3;
        box-shadow: 0 0 0 4px rgba(1, 145, 179, 0.15);
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
            <h1 class="pdf-section-title">Hubungi Kami</h1>
        </div>
    </div>
</section>

<!-- CONTACT SECTION (MATCHING PAGE 16 PDF) -->
<section class="section-padding">
    <div class="container">
        
        @if(session('success'))
        <div style="background-color: #d1e7dd; color: #0f5132; padding: 16px 20px; border-radius: 8px; margin-bottom: 30px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i>
            {{ session('success') }}
        </div>
        @endif

        <div class="grid-2" style="align-items: start; gap: 50px;">
            
            <!-- LEFT COLUMN: WORKSHOP ADDRESS & GOOGLE MAPS -->
            <div>
                <div style="display: flex; gap: 14px; align-items: flex-start; margin-bottom: 24px;">
                    <i class="fa-solid fa-location-dot" style="color: #ea4335; font-size: 2rem; margin-top: 4px;"></i>
                    <p style="font-size: 1.1rem; font-weight: 600; color: #333333; line-height: 1.6;">
                        Workshop : Jl. Kalijaga No 162 Pegambiran, Kec. Lemahwungkuk, Kota Cirebon Jawa Barat 45113
                    </p>
                </div>

                <div style="width: 100%; height: 340px; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-sm); border: 1px solid #e2e8f0;">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.247194165651!2d108.5714!3d-6.7397!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6ee2e8f192b67f%3A0x89d46f5b9d3e8a4a!2sJl.%20Kalijaga%20No.162%2C%20Pegambiran%2C%20Kec.%20Lemahwungkuk%2C%20Kota%20Cirebon%2C%20Jawa%20Barat%2045113!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            <!-- RIGHT COLUMN: FORM (MATCHING PAGE 16 PDF) -->
            <div style="width: 100%;">
                <form action="{{ route('contact.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 20px; width: 100%;">
                    @csrf
                    <div style="width: 100%;">
                        <input type="text" name="name" class="form-control-custom" placeholder="NAME" required>
                    </div>

                    <div style="width: 100%;">
                        <input type="email" name="email" class="form-control-custom" placeholder="EMAIL" required>
                    </div>

                    <div style="width: 100%;">
                        <textarea name="message" class="form-control-custom" placeholder="MESSAGE" style="min-height: 160px; resize: vertical;" required></textarea>
                    </div>

                    <div style="text-align: right; margin-top: 10px; width: 100%;">
                        <button type="submit" class="btn-pill btn-pill-primary" style="padding: 12px 48px; font-size: 1rem; font-weight: 700;">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>

@endsection
