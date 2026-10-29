<?php

namespace Tests\Unit;

use App\Services\SeoScoringService;
use PHPUnit\Framework\TestCase;

class SeoScoringServiceTest extends TestCase
{
    protected SeoScoringService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SeoScoringService;
    }

    /**
     * Helper to generate dummy paragraphs to meet word count targets.
     */
    protected function generateWords(int $count, string $word = 'fabrikasi presisi'): string
    {
        $words = [];
        for ($i = 0; $i < $count; $i++) {
            $words[] = 'kata'.$i;
        }

        return implode(' ', $words);
    }

    public function test_article_with_all_checks_passing_gets_full_score(): void
    {
        $filler = $this->generateWords(310);
        $data = [
            'title' => 'Layanan Fabrikasi Presisi di Cirebon',
            'meta_title' => 'Layanan Fabrikasi Presisi Cirebon Terbaik 2026', // 46 chars
            'focus_keyword' => 'Fabrikasi Presisi',
            'slug' => 'layanan-fabrikasi-presisi-cirebon',
            'meta_description' => 'PT Makmur Bersama Enjiniring menyediakan layanan fabrikasi presisi dengan mesin modern CNC dan standar kualitas industri terbaik di Cirebon.', // 142 chars
            'raw_content' => '<p>Kami menghadirkan layanan Fabrikasi Presisi untuk industri modern di Cirebon.</p>'.
                '<h2>Keunggulan Fabrikasi Presisi Kami</h2>'.
                '<p>'.$filler.'</p>'.
                '<p>Pelajari lebih lanjut di <a href="/layanan">halaman layanan kami</a> untuk informasi detail.</p>',
            'image' => 'assets/images/news/sample.jpg',
            'image_alt' => 'Workshop fabrikasi presisi PT Makmur Bersama Enjiniring',
        ];
        $data['content'] = $data['raw_content'];

        $result = $this->service->analyze($data);

        $this->assertEquals(100, $result['score']);
        $this->assertEquals('good', $result['status']);
        $this->assertTrue($result['has_focus_keyword']);
        $this->assertCount(10, $result['checks']);

        foreach ($result['checks'] as $check) {
            $this->assertEquals('passed', $check['status'], "Check {$check['id']} should pass");
            $this->assertEquals($check['max_score'], $check['score']);
        }
    }

    public function test_article_with_no_focus_keyword_marked_incomplete(): void
    {
        $data = [
            'title' => 'Layanan Fabrikasi Presisi Cirebon',
            'meta_title' => 'Layanan Fabrikasi Presisi Cirebon 2026',
            'focus_keyword' => '',
            'slug' => 'layanan-fabrikasi-presisi',
            'meta_description' => 'Deskripsi artikel yang cukup panjang dan informatif untuk memenuhi batas karakter pencarian mesin pencari Google Indonesia.',
            'content' => '<p>Artikel tanpa kata kunci.</p>',
            'image' => '',
            'image_alt' => '',
        ];

        $result = $this->service->analyze($data);

        $this->assertFalse($result['has_focus_keyword']);
        $this->assertEquals('incomplete', $result['status']);
        $this->assertLessThan(100, $result['score']);
    }

    public function test_missing_seo_title_and_meta_description(): void
    {
        $data = [
            'title' => 'Pendek',
            'meta_title' => '',
            'focus_keyword' => 'Pendek',
            'slug' => 'pendek',
            'meta_description' => '',
            'content' => '<p>Hanya satu kalimat.</p>',
            'image' => '',
            'image_alt' => '',
        ];

        $result = $this->service->analyze($data);

        $checks = collect($result['checks'])->keyBy('id');
        $this->assertEquals('failed', $checks['title_length']['status']);
        $this->assertEquals('failed', $checks['meta_description_length']['status']);
        $this->assertEquals(0, $checks['meta_description_length']['score']);
    }

    public function test_missing_featured_image_and_alt_text(): void
    {
        $data = [
            'title' => 'Artikel Tanpa Gambar Utama Dan Teks Alt',
            'focus_keyword' => 'Gambar',
            'slug' => 'artikel-tanpa-gambar',
            'content' => '<p>Konten artikel.</p>',
            'image' => '',
            'image_alt' => '',
        ];

        $result = $this->service->analyze($data);
        $checks = collect($result['checks'])->keyBy('id');

        $this->assertEquals('failed', $checks['featured_image']['status']);
        $this->assertEquals(0, $checks['featured_image']['score']);
    }

    public function test_image_present_without_alt_text_gets_warning(): void
    {
        $data = [
            'title' => 'Artikel Dengan Gambar Tapi Tanpa Alt Text',
            'focus_keyword' => 'Gambar',
            'slug' => 'artikel-dengan-gambar',
            'content' => '<p>Konten artikel.</p>',
            'image' => 'assets/images/sample.jpg',
            'image_alt' => '',
        ];

        $result = $this->service->analyze($data);
        $checks = collect($result['checks'])->keyBy('id');

        $this->assertEquals('warning', $checks['featured_image']['status']);
        $this->assertEquals(5, $checks['featured_image']['score']);
    }

    public function test_empty_content_handled_safely(): void
    {
        $data = [
            'title' => '',
            'focus_keyword' => 'Uji',
            'content' => '',
        ];

        $result = $this->service->analyze($data);

        $this->assertIsInt($result['score']);
        $this->assertEquals(0, $result['word_count']);
        $this->assertEquals('poor', $result['status']);
    }

    public function test_content_with_html_scripts_and_styles_stripped(): void
    {
        $html = '<script>var bad = "Machining CNC";</script>'.
                '<style>.cnc { color: red; }</style>'.
                '<p>PT MBE adalah penyedia solusi <span class="badge">Machining CNC</span> terkemuka.</p>';

        $data = [
            'title' => 'Pusat Machining CNC Berkualitas di Cirebon',
            'focus_keyword' => 'Machining CNC',
            'slug' => 'pusat-machining-cnc-berkualitas',
            'content' => $html,
        ];

        $result = $this->service->analyze($data);
        $checks = collect($result['checks'])->keyBy('id');

        $this->assertEquals('passed', $checks['keyword_in_first_paragraph']['status']);
        $this->assertGreaterThan(0, $result['word_count']);
    }

    public function test_case_insensitive_and_unicode_keyword_matching(): void
    {
        $data = [
            'title' => 'Inovasi Logam & Fabrikasi Presisi Cirebon',
            'meta_title' => 'Inovasi Logam & Fabrikasi Presisi Cirebon 2026',
            'focus_keyword' => 'FABRIKASI PRESISI',
            'slug' => 'inovasi-logam-fabrikasi-presisi-cirebon',
            'content' => '<p>Melalui proses fabrikasi presisi dengan toleransi mikro.</p>',
        ];

        $result = $this->service->analyze($data);
        $checks = collect($result['checks'])->keyBy('id');

        $this->assertEquals('passed', $checks['keyword_in_title']['status']);
        $this->assertEquals('passed', $checks['keyword_in_slug']['status']);
        $this->assertEquals('passed', $checks['keyword_in_first_paragraph']['status']);
    }

    public function test_excessive_keyword_repetition_triggers_stuffing_warning(): void
    {
        // 50 total words, keyword repeated 15 times (> 30% density)
        $repeatedKw = str_repeat('Machining CNC ', 15);
        $filler = $this->generateWords(30);

        $data = [
            'title' => 'Machining CNC Machining CNC Machining CNC',
            'focus_keyword' => 'Machining CNC',
            'content' => '<p>'.$repeatedKw.' '.$filler.'</p>',
        ];

        $result = $this->service->analyze($data);
        $checks = collect($result['checks'])->keyBy('id');

        $this->assertEquals('warning', $checks['keyword_density']['status']);
        $this->assertStringContainsString('keyword stuffing', strtolower($checks['keyword_density']['explanation']));
        $this->assertLessThan(10, $checks['keyword_density']['score']);
    }

    public function test_score_boundaries_strictly_between_0_and_100(): void
    {
        // Empty
        $emptyResult = $this->service->analyze([]);
        $this->assertGreaterThanOrEqual(0, $emptyResult['score']);
        $this->assertLessThanOrEqual(100, $emptyResult['score']);

        // Full
        $fullFiller = $this->generateWords(350);
        $fullResult = $this->service->analyze([
            'title' => 'Pusat Mesin CNC Canggih & Presisi di Cirebon',
            'meta_title' => 'Pusat Mesin CNC Canggih Presisi di Cirebon 2026',
            'focus_keyword' => 'Mesin CNC',
            'slug' => 'pusat-mesin-cnc-canggih-presisi',
            'meta_description' => 'Kami melayani pengerjaan komponen industri dengan mesin CNC berkecepatan tinggi serta operator berpengalaman di wilayah Cirebon.',
            'content' => '<p>Pusat Mesin CNC terbaik siap melayani proyek Anda.</p><h2>Layanan Mesin CNC</h2><p>'.$fullFiller.'</p><a href="/produk">Produk</a>',
            'image' => 'assets/images/cnc.jpg',
            'image_alt' => 'Operasi mesin CNC di pabrik MBE Cirebon',
        ]);

        $this->assertGreaterThanOrEqual(0, $fullResult['score']);
        $this->assertLessThanOrEqual(100, $fullResult['score']);
        $this->assertEquals(100, $fullResult['score']);
    }

    public function test_scoring_is_deterministic_for_identical_input(): void
    {
        $data = [
            'title' => 'Pengujian Konsistensi Skor SEO Engine MBE',
            'meta_title' => 'Pengujian Konsistensi Skor SEO Engine MBE 2026',
            'focus_keyword' => 'Skor SEO',
            'slug' => 'pengujian-konsistensi-skor-seo-engine-mbe',
            'meta_description' => 'Artikel ini digunakan untuk memverifikasi bahwa algoritma penilaian SEO menghasilkan nilai yang stabil dan dapat diprediksi secara konsisten.',
            'content' => '<p>Implementasi Skor SEO yang stabil pada aplikasi web.</p><h2>Manfaat Skor SEO</h2><p>'.$this->generateWords(200).'</p><a href="/layanan">Layanan</a>',
            'image' => 'assets/news.png',
            'image_alt' => 'Grafik evaluasi skor SEO artikel',
        ];

        $run1 = $this->service->analyze($data);
        $run2 = $this->service->analyze($data);

        $this->assertEquals($run1['score'], $run2['score']);
        $this->assertEquals($run1['checks'], $run2['checks']);
    }
}
