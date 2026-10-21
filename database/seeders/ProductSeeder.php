<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categoriesData = [
            'manufaktur' => [
                'name' => 'Manufaktur',
                'slug' => 'manufaktur',
                'subtitle' => 'Profile PVC & Extrusion Manufaktur',
                'icon' => 'fa-solid fa-gears',
                'header_img' => 'assets/images/page_produk_1/mesin injection 1.png',
                'description' => 'Kami menyediakan layanan manufaktur yang mencakup proses produksi secara menyeluruh, mulai dari perencanaan dan pengolahan bahan baku hingga menjadi produk setengah jadi maupun produk jadi sesuai spesifikasi teknis. Didukung oleh tenaga kerja berpengalaman, peralatan produksi yang memadai, serta sistem kontrol kualitas yang ketat, PT Makmur Bersama Enjiniring mampu menghasilkan produk manufaktur dengan tingkat presisi, konsistensi, dan keandalan tinggi untuk mendukung berbagai kebutuhan industri.',
                'category_name' => 'Profile PVC',
                'gallery_folder' => 'page_produk_1',
                'sort_order' => 1,
                'items' => [
                    ['name' => 'Profile PVC Duct Cable', 'specs' => '60 x 40', 'image' => 'profile pvc 1.png'],
                    ['name' => 'Profile PVC Duct Floor', 'specs' => '23,2 x 31', 'image' => 'profile pvc 2.png'],
                    ['name' => 'Profile PVC Sekat', 'specs' => '74 x 40 x 34 x 2', 'image' => 'profile pvc 3.png'],
                    ['name' => 'Profile PVC Elbow', 'specs' => '30 x 50 x 3m', 'image' => 'profile pvc 4.png'],
                    ['name' => 'Pipa PVC', 'specs' => '2" x 3m', 'image' => 'profile pvc 5.png'],
                    ['name' => 'Profile PVC Oval', 'specs' => '20 x 68', 'image' => 'profile pvc 6.png'],
                    ['name' => 'Profile PVC T', 'specs' => '50 x 100 x 40', 'image' => 'profile pvc 7.png'],
                    ['name' => 'Protector Lan', 'specs' => 'Atas 20 x 1,7mm / Bawah 70,8 x 1,15mm', 'image' => 'profile pvc 8.png'],
                ]
            ],
            'machining-cnc' => [
                'name' => 'Machining CNC & Plastic',
                'slug' => 'machining-cnc',
                'subtitle' => 'Pengerjaan CNC Presisi Tinggi Metal & Plastik Teknik',
                'icon' => 'fa-solid fa-microchip',
                'header_img' => 'assets/images/page_produk_2/mesin cnc.png',
                'description' => 'Kami menyediakan layanan machining CNC metal & plastik dengan tingkat presisi tinggi untuk memenuhi kebutuhan komponen industri yang menuntut akurasi dan konsistensi kualitas. Proses pengerjaan dilakukan menggunakan mesin CNC modern dan ditangani oleh tenaga berpengalaman, sehingga mampu mengerjakan berbagai material seperti baja, stainless steel, aluminium, serta plastik teknik sesuai gambar kerja dan toleransi yang ditentukan.',
                'category_name' => 'Produk Machining CNC',
                'gallery_folder' => 'page_produk_2',
                'sort_order' => 2,
                'items' => [
                    ['name' => 'CNC Custom Part 01', 'specs' => 'Custom Metal / Plastic', 'image' => 'produk machining 1.png'],
                    ['name' => 'Precision Gear Wheel', 'specs' => 'Bronze / Steel', 'image' => 'produk machining 2.png'],
                    ['name' => 'CNC Turning Component', 'specs' => 'Toleransi High Precision', 'image' => 'produk machining 3.png'],
                    ['name' => 'Bushing & Roller CNC', 'specs' => 'Industrial Grade', 'image' => 'produk machining 4.png'],
                    ['name' => 'Mould & Die Component', 'specs' => 'Hardened Steel', 'image' => 'produk machining 5.png'],
                    ['name' => 'Plastic Engineering Part', 'specs' => 'POM / Teflon / Nylon', 'image' => 'produk machining 6.png'],
                    ['name' => 'Custom Flange & Coupling', 'specs' => 'Stainless Steel 304/316', 'image' => 'produk machining 7.png'],
                    ['name' => 'Special Fixture & Jig', 'specs' => 'Assembly Component', 'image' => 'produk machining 8.png'],
                ]
            ],
            'fabrikasi' => [
                'name' => 'Fabrikasi Logam',
                'slug' => 'fabrikasi',
                'subtitle' => 'Pemotongan, Pembentukan, Pengelasan & Finishing Logam',
                'icon' => 'fa-solid fa-industry',
                'header_img' => 'assets/images/page_produk_3/fabrikasi foto.png',
                'description' => 'Kami menyediakan layanan fabrikasi untuk berbagai kebutuhan industri yang mencakup proses pemotongan, pembentukan, pengelasan, hingga finishing material logam. Dengan dukungan tenaga kerja berpengalaman dan peralatan kerja yang memadai, PT Makmur Bersama Enjiniring mampu menghasilkan produk fabrikasi yang kuat, presisi, dan sesuai spesifikasi teknis.',
                'category_name' => 'Produk Fabrikasi Logam',
                'gallery_folder' => 'page_produk_3',
                'sort_order' => 3,
                'items' => [
                    ['name' => 'Rangka Structure Heavy Duty', 'specs' => 'Mild Steel / Stainless', 'image' => 'produk fabrikasi 1.png'],
                    ['name' => 'Trolley & Conveyor Frame', 'specs' => 'Custom Industrial', 'image' => 'produk fabrikasi 2.png'],
                    ['name' => 'Laser Cut Metal Sheet', 'specs' => 'High Precision Cutting', 'image' => 'produk fabrikasi 3.png'],
                    ['name' => 'Storage Rack & Shelf', 'specs' => 'Warehouse Spec', 'image' => 'produk fabrikasi 4.png'],
                    ['name' => 'Machine Base Frame', 'specs' => 'Vibration Proof Weld', 'image' => 'produk fabrikasi 5.png'],
                    ['name' => 'Stainless Bending Ducting', 'specs' => 'Plate Bending', 'image' => 'produk fabrikasi 6.png'],
                    ['name' => 'Industrial Enclosure Box', 'specs' => 'Powder Coating Finish', 'image' => 'produk fabrikasi 7.png'],
                    ['name' => 'Custom Welding Structure', 'specs' => 'TIG / MIG Welding', 'image' => 'produk fabrikasi 8.png'],
                ]
            ],
            'general-trading-material' => [
                'name' => 'General Trading Material',
                'slug' => 'general-trading-material',
                'subtitle' => 'Pengadaan Material Logam & Plastik Industri Terpercaya',
                'icon' => 'fa-solid fa-cubes',
                'header_img' => 'assets/images/page_produk_4/foto general trading.png',
                'description' => 'Kami menyediakan layanan General Trading untuk mendukung kebutuhan pengadaan berbagai produk dan material industri secara tepat, efisien, dan terpercaya. PT Makmur Bersama Enjiniring melayani pengadaan spare part mesin, material logam dan non-logam, serta peralatan pendukung industri.',
                'category_name' => 'Raw Material & Trading',
                'gallery_folder' => 'page_produk_4',
                'sort_order' => 4,
                'items' => [
                    ['name' => 'Plat Stainless Steel 304', 'specs' => 'Tebal 1mm - 20mm', 'image' => 'produk general trading 1.png'],
                    ['name' => 'As Round Bar Aluminium', 'specs' => 'Dia 10mm - 200mm', 'image' => 'produk general trading 2.png'],
                    ['name' => 'Plastik Teknik Sheet POM', 'specs' => 'White / Black Sheet', 'image' => 'produk general trading 3.png'],
                    ['name' => 'Pipa Brass & Tembaga', 'specs' => 'Seamless Pipe', 'image' => 'produk general trading 4.png'],
                    ['name' => 'Teflon PTFE Rod', 'specs' => 'High Temp Resistant', 'image' => 'produk general trading 5.png'],
                    ['name' => 'Besi As VCN / S45C', 'specs' => 'Hardened Steel Rod', 'image' => 'produk general trading 6.png'],
                ]
            ],
            'general-trading-lean-pipe' => [
                'name' => 'Lean Pipe System',
                'slug' => 'general-trading-lean-pipe',
                'subtitle' => 'Pengadaan Lean Pipe & Metal Joint Rangka Kerja',
                'icon' => 'fa-solid fa-diagram-project',
                'header_img' => 'assets/images/page_produk_5/foto piping.png',
                'description' => 'Pengadaan sistem Lean Pipe dan Metal Joint fleksibel untuk kebutuhan pembuatan rak kerja, trolley, dan struktur pendukung produksi manufaktur yang ergonomis.',
                'category_name' => 'Lean Pipe & Joint',
                'gallery_folder' => 'page_produk_5',
                'sort_order' => 5,
                'items' => [
                    ['name' => 'Lean Pipe Coated Outer 28mm', 'specs' => 'Panjang 4 Meter', 'image' => 'produk piping 1.png'],
                    ['name' => 'Metal Joint HJ-1 Black', 'specs' => 'Connection Fitting', 'image' => 'produk piping 2.png'],
                    ['name' => 'Metal Joint HJ-2 Chrome', 'specs' => 'T-Joint Connector', 'image' => 'produk piping 3.png'],
                    ['name' => 'Roller Track Conveyor', 'specs' => 'Aluminium Slide', 'image' => 'produk piping 4.png'],
                    ['name' => 'Placon Mount Bracket', 'specs' => 'Fixing Component', 'image' => 'produk piping 5.png'],
                    ['name' => 'Lean Pipe Caster Adapter', 'specs' => 'Threaded Bushing', 'image' => 'produk piping 6.png'],
                ]
            ],
            'general-trading-piping' => [
                'name' => 'Gas Piping System',
                'slug' => 'general-trading-piping',
                'subtitle' => 'Sistem Perpipaan Gas Alam, LPG & Gas Industri',
                'icon' => 'fa-solid fa-fire-flame-simple',
                'header_img' => 'assets/images/page_produk_6/foto produk general trading 1.png',
                'description' => 'Kami menyediakan layanan Instalasi Pipa Gas atau Gas Piping system khusus untuk mengalirkan gas alam, LPG, atau jenis gas industri dari sumber suplai ke titik konsumsi dengan keamanan dan keandalan terjamin.',
                'category_name' => 'Gas Piping & Valves',
                'gallery_folder' => 'page_produk_6',
                'sort_order' => 6,
                'items' => [
                    ['name' => 'Pipa Gas Carbon Steel Sch 40', 'specs' => 'High Pressure Spec', 'image' => 'foto produk general trading 1.png'],
                    ['name' => 'Ball Valve Gas Stainless 1000 WOG', 'specs' => 'Flange / Threaded', 'image' => 'foto produk general trading 2.png'],
                    ['name' => 'Gas Pressure Regulator', 'specs' => 'Dual Stage Control', 'image' => 'foto produk general trading 3.png'],
                    ['name' => 'Solenoid Valve Safety Gas', 'specs' => 'Explosion Proof', 'image' => 'foto produk general trading 4.png'],
                    ['name' => 'Gas Leak Detector System', 'specs' => 'Industrial Alarm', 'image' => 'foto produk general trading 5.png'],
                    ['name' => 'Flexible Hose High Temp', 'specs' => 'Braided Stainless', 'image' => 'foto produk general trading 6.png'],
                ]
            ],
            'general-trading-caster' => [
                'name' => 'Caster Wheel',
                'slug' => 'general-trading-caster',
                'subtitle' => 'Roda Industri Tugas Berat & Trolley Presisi',
                'icon' => 'fa-solid fa-circle-notch',
                'header_img' => 'assets/images/page_produk_7/chaster wheel.png',
                'description' => 'Suplai roda caster heavy-duty industri berbagai ukuran dan daya tahan beban untuk kelancaran transportasi logistik internal pabrik Anda.',
                'category_name' => 'Roda Caster Industri',
                'gallery_folder' => 'page_produk_7',
                'sort_order' => 7,
                'items' => [
                    ['name' => 'Heavy Duty PU Caster Swivel', 'specs' => 'Cap 500kg / Wheel', 'image' => 'wheel 1.png'],
                    ['name' => 'Nylon Caster Rigid Wheel', 'specs' => 'Beban 300kg', 'image' => 'wheel 2.png'],
                    ['name' => 'Rubber Caster Brake System', 'specs' => 'Ukuran 4" - 8"', 'image' => 'wheel 3.png'],
                    ['name' => 'ESD Antistatic Caster Wheel', 'specs' => 'Cleanroom Spec', 'image' => 'wheel 4.png'],
                    ['name' => 'Iron Core PU Industrial Wheel', 'specs' => 'Beban Heavy 1 Ton', 'image' => 'wheel 5.png'],
                ]
            ],
            'general-trading-perlengkapan' => [
                'name' => 'Perlengkapan Industri',
                'slug' => 'general-trading-perlengkapan',
                'subtitle' => 'Komponen & Perlengkapan Pendukung Pabrik',
                'icon' => 'fa-solid fa-toolbox',
                'header_img' => 'assets/images/page_produk_8/perlengkapan.png',
                'description' => 'Berbagai perlengkapan pendukung fasilitas industri, komponen mesin, fixture, hingga asesoris kerja pabrik.',
                'category_name' => 'Perlengkapan Pabrik',
                'gallery_folder' => 'page_produk_8',
                'sort_order' => 8,
                'items' => [
                    ['name' => 'Worktable Anti Static Mat', 'specs' => 'ESD Rubber Sheet', 'image' => 'produk perlengkapan 1.png'],
                    ['name' => 'Industrial Storage Bin Box', 'specs' => 'Stackable Plastic', 'image' => 'produk perlengkapan 2.png'],
                    ['name' => 'Leveling Foot Heavy Duty', 'specs' => 'M12 / M16 / M20 Thread', 'image' => 'produk perlengkapan 3.png'],
                    ['name' => 'Industrial Hinge & Latch', 'specs' => 'Stainless Steel 304', 'image' => 'produk perlengkapan 4.png'],
                    ['name' => 'Vibration Damper Mount', 'specs' => 'Anti Vibration Rubber', 'image' => 'produk perlengkapan 5.png'],
                    ['name' => 'Cable Drag Chain Duct', 'specs' => 'Nylon Cable Carrier', 'image' => 'produk perlengkapan 6.png'],
                ]
            ],
            'general-trading-tools' => [
                'name' => 'Tools & APD',
                'slug' => 'general-trading-tools',
                'subtitle' => 'Peralatan Kerja Power Tools & Alat Pelindung Diri',
                'icon' => 'fa-solid fa-screwdriver-wrench',
                'header_img' => 'assets/images/page_produk_9/tools.png',
                'description' => 'Penyediaan perkakas mesin, hand tools, serta Alat Pelindung Diri (APD) standar keselamatan kerja industri.',
                'category_name' => 'Power Tools & APD',
                'gallery_folder' => 'page_produk_9',
                'sort_order' => 9,
                'items' => [
                    ['name' => 'Safety Helmet V-Gard', 'specs' => 'ANSI Z89.1 Standard', 'image' => 'produk tools 1.png'],
                    ['name' => 'Hand Tools Set Mechanical', 'specs' => 'Chrome Vanadium', 'image' => 'produk tools 2.png'],
                    ['name' => 'Pneumatic Impact Wrench', 'specs' => '1/2 Inch Drive', 'image' => 'produk tools 3.png'],
                    ['name' => 'Safety Shoes Steel Toe Cap', 'specs' => 'Oil & Heat Resistant', 'image' => 'produk tools 4.png'],
                    ['name' => 'Welding Helmet Auto Darkening', 'specs' => 'Solar Powered', 'image' => 'produk tools 5.png'],
                    ['name' => 'Cut Resistant Glove Class 5', 'specs' => 'PU Coated Palm', 'image' => 'produk tools 6.png'],
                ]
            ],
        ];

        foreach ($categoriesData as $catKey => $catData) {
            $items = $catData['items'];
            unset($catData['items']);

            $category = ProductCategory::updateOrCreate(
                ['slug' => $catData['slug']],
                $catData
            );

            foreach ($items as $index => $item) {
                Product::updateOrCreate(
                    [
                        'product_category_id' => $category->id,
                        'name' => $item['name']
                    ],
                    [
                        'slug' => Str::slug($item['name']),
                        'specs' => $item['specs'],
                        'image' => $item['image'],
                        'is_active' => true,
                        'sort_order' => $index + 1
                    ]
                );
            }
        }
    }
}
