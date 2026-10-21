<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        News::query()->delete();

        News::create([
            'title' => 'Pengembangan Fasilitas Mesin CNC Presisi Tinggi di PT MBE',
            'slug' => 'pengembangan-fasilitas-mesin-cnc-presisi-tinggi',
            'published_at' => '2025-09-15',
            'image' => 'assets/images/page_beranda/foto produk kami machining CNC.png',
            'excerpt' => 'PT Makmur Bersama Enjiniring terus menginvestasikan teknologi mesin CNC presisi tinggi untuk meningkatkan kualitas spare part industri.',
            'content' => '<p>Sebagai komitmen dalam memberikan pelayanan terbaik bagi mitra industri, PT Makmur Bersama Enjiniring secara berkelanjutan melakukan modernisasi perangkat mesin CNC. Dengan penambahan kapasitas pengerjaan ini, proses machining material baja, aluminium, hingga plastik teknik dapat diselesaikan dengan tingkat toleransi presisi yang semakin tinggi dan waktu pengerjaan yang lebih cepat.</p><p>Pengembangan ini mencakup mesin Milling CNC 5-Axis dan Bubut CNC presisi tinggi yang didukung oleh sistem CAD/CAM mutakhir untuk menangani pola rumit spesifikasi otomotif dan manufaktur modern.</p>',
            'is_headline' => true,
            'focus_keyword' => 'mesin CNC presisi tinggi',
            'meta_title' => 'Fasilitas Mesin CNC Presisi Tinggi di PT MBE Cirebon',
            'meta_description' => 'PT Makmur Bersama Enjiniring menghadirkan teknologi mesin CNC presisi tinggi untuk pembuatan spare part industri baja, aluminium, dan plastik teknik.',
        ]);

        News::create([
            'title' => 'Penerapan Teknologi Fiber Laser Cutting Terbaru',
            'slug' => 'penerapan-teknologi-fiber-laser-cutting-terbaru',
            'published_at' => '2025-08-10',
            'image' => 'assets/images/page_beranda/foto produk kami fabrikasi.png',
            'excerpt' => 'Layanan pemotongan plat logam dengan teknologi Laser Cutting presisi tanpa perlu finishing tambahan.',
            'content' => '<p>Teknologi Fiber Laser Cutting yang diterapkan di workshop PT Makmur Bersama Enjiniring memungkinkan pemotongan plat logam tebal dengan pola rumit dan hasil pemotongan yang sangat presisi dan halus, menghemat waktu proses produksi mitra kerja.</p><p>Proses pemotongan cepat dan bebas burr memastikan setiap komponen plat baja dan stainless steel siap langsung masuk tahap perakitan.</p>',
            'is_headline' => false,
            'focus_keyword' => 'Fiber Laser Cutting',
            'meta_title' => 'Layanan Fiber Laser Cutting Logam Presisi - PT MBE',
            'meta_description' => 'Layanan pemotongan laser fiber presisi tinggi tanpa proses finishing tambahan untuk produksi plat logam industri.',
        ]);

        News::create([
            'title' => 'Komitmen Keselamatan dan Kualitas dalam Instalasi Gas Piping',
            'slug' => 'komitmen-keselamatan-dan-kualitas-dalam-instalasi-gas-piping',
            'published_at' => '2025-07-02',
            'image' => 'assets/images/page_layanan_kami/layanan kami piping.png',
            'excerpt' => 'Standar keamanan ketat diterapkan pada proyek pemasangan jaringan pipa gas industri.',
            'content' => '<p>Sistem perpipaan gas industri menuntut tingkat keamanan dan ketahanan yang sangat tinggi. Tim teknisi ahli PT Makmur Bersama Enjiniring mengutamakan uji kebocoran dan spesifikasi pipa berkualitas tinggi untuk menjaga keamanan fasilitas pabrik pelanggan.</p><p>Setiap sambungan dilas oleh welder bersertifikasi ISO dan melalui tahap hydrostatic pressure test sebelum serah terima proyek.</p>',
            'is_headline' => false,
            'focus_keyword' => 'Instalasi Gas Piping',
            'meta_title' => 'Instalasi Gas Piping Industri Aman & Terpercaya - PT MBE',
            'meta_description' => 'Jasa instalasi pipa gas alam dan LPG industri dengan uji tekanan hidrostatik dan standar keselamatan ketat dari PT MBE.',
        ]);
    }
}
