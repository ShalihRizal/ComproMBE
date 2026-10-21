<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolioItems = [
            [
                'id' => 1,
                'title' => 'Pengadaan & Perakitan Line Extrusion Manufaktur',
                'category' => 'manufaktur',
                'category_name' => 'Manufaktur & Extrusion',
                'description' => 'Fabrikasi dan pemasangan lini produksi extrusion & moulding presisi tinggi untuk industri plastik.',
                'image' => 'portof1.png',
                'featured' => true
            ],
            [
                'id' => 2,
                'title' => 'Fabrikasi Rangka Structure Heavy Duty',
                'category' => 'fabrikasi',
                'category_name' => 'Fabrikasi Logam',
                'description' => 'Konstruksi dan pengelasan rangka baja industri beban berat.',
                'image' => 'portof2.png',
                'featured' => false
            ],
            [
                'id' => 3,
                'title' => 'Pengerjaan Precision CNC Turning Part',
                'category' => 'machining',
                'category_name' => 'Machining CNC',
                'description' => 'Komponen turning CNC toleransi tinggi untuk part otomotif & mesin.',
                'image' => 'portof3.png',
                'featured' => false
            ],
            [
                'id' => 4,
                'title' => 'Instalasi Sistem Perpipaan Gas Industri',
                'category' => 'piping',
                'category_name' => 'Gas Piping System',
                'description' => 'Pemasangan jaringan pipa gas high pressure lengkap dengan regulator & valve.',
                'image' => 'portof4.png',
                'featured' => false
            ],
            [
                'id' => 5,
                'title' => 'Profile PVC Duct Cable & Cable Protector',
                'category' => 'manufaktur',
                'category_name' => 'Manufaktur PVC',
                'description' => 'Produksi massal profile PVC pelindung kabel standar industri.',
                'image' => 'portof5.png',
                'featured' => false
            ],
            [
                'id' => 6,
                'title' => 'Pemotongan Laser Cut Metal Sheet Presisi',
                'category' => 'fabrikasi',
                'category_name' => 'Laser Cutting & Bending',
                'description' => 'Laser cutting plat stainless steel & mild steel dengan ketelitian milimeter.',
                'image' => 'portof6.png',
                'featured' => false
            ],
            [
                'id' => 7,
                'title' => 'Perakitan Custom Trolley & Lean Pipe System',
                'category' => 'piping',
                'category_name' => 'Lean Pipe System',
                'description' => 'Pembuatan rak conveyor dan trolley kerja fleksibel untuk pabrik.',
                'image' => 'portof7.png',
                'featured' => false
            ],
            [
                'id' => 8,
                'title' => 'Suplai Roda Caster Heavy Duty PU Wheel',
                'category' => 'trading',
                'category_name' => 'Caster Wheel',
                'description' => 'Roda caster industri daya tahan beban hingga 1 Ton.',
                'image' => 'portof8.png',
                'featured' => false
            ],
            [
                'id' => 9,
                'title' => 'Pembuatan Custom Jig & Fixture Tooling',
                'category' => 'machining',
                'category_name' => 'Machining CNC',
                'description' => 'Pengerjaan alat bantu ukur dan penahan komponen produksi.',
                'image' => 'portof9.png',
                'featured' => false
            ],
            [
                'id' => 10,
                'title' => 'Mould & Die Component Tooling',
                'category' => 'machining',
                'category_name' => 'Machining CNC',
                'description' => 'Komponen cetakan plastik dari bahan baja terkeras.',
                'image' => 'portof10.png',
                'featured' => false
            ],
            [
                'id' => 11,
                'title' => 'Fabrikasi Ducting Air Handling Unit',
                'category' => 'fabrikasi',
                'category_name' => 'Fabrikasi Logam',
                'description' => 'Instalasi sistem saluran udara dan ventilasi pabrik.',
                'image' => 'portof11.png',
                'featured' => false
            ],
            [
                'id' => 12,
                'title' => 'Suplai Raw Material Stainless & Brass',
                'category' => 'trading',
                'category_name' => 'General Trading',
                'description' => 'Pengadaan material as bulat, plat, dan pipa teknik.',
                'image' => 'portof12.png',
                'featured' => false
            ]
        ];

        return view('portfolio', compact('portfolioItems'));
    }
}
