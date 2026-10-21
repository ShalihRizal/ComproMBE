<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\ProductCategory;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch dynamic product categories from DB
        $productCategories = ProductCategory::orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();

        $services = [
            ['title' => 'Rolling', 'icon' => asset('assets/images/page_beranda/icon rol plat.png'), 'desc' => 'Penggulungan plat & pipa logam dengan keakuratan radius tinggi.'],
            ['title' => 'Bending', 'icon' => asset('assets/images/page_beranda/icon bending.png'), 'desc' => 'Penekukan plat logam presisi dengan mesin Press Brake modern.'],
            ['title' => 'Welding', 'icon' => asset('assets/images/page_beranda/icon welding.png'), 'desc' => 'Pengelasan profesional yang rapi, kuat, dan tahan lama.'],
            ['title' => 'Laser Cutting', 'icon' => asset('assets/images/page_beranda/icon laser cutting.png'), 'desc' => 'Pemotongan laser fiber presisi tinggi tanpa perlu finishing tambahan.'],
            ['title' => 'Ducting', 'icon' => asset('assets/images/page_beranda/icon ducting.png'), 'desc' => 'Sistem sirkulasi udara & pembuangan untuk gedung & fasilitas industri.'],
            ['title' => 'Piping', 'icon' => asset('assets/images/page_beranda/icon piping.png'), 'desc' => 'Instalasi perpipaan gas industri & LPG dari sumber ke konsumsi.'],
        ];

        // Fetch dynamic Headline article & Recent articles from DB
        $headlineNews = News::where('is_headline', true)->orderBy('published_at', 'desc')->first();
        if (!$headlineNews) {
            $headlineNews = News::orderBy('published_at', 'desc')->first();
        }

        $recentNews = News::where('id', '!=', optional($headlineNews)->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('home', compact('productCategories', 'services', 'headlineNews', 'recentNews'));
    }
}
