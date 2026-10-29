<?php

namespace Tests\Feature;

use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class NewsSeoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Helper to authenticate admin session.
     */
    protected function authenticateAdmin(): void
    {
        session([
            'admin_logged_in' => true,
            'admin_email' => 'admin@makben.co.id',
            'admin_name' => 'Administrator MBE',
        ]);
    }

    public function test_can_create_news_with_seo_fields_and_persisted_score(): void
    {
        $this->authenticateAdmin();

        $response = $this->post(route('admin.news.store'), [
            'title' => 'Ekspansi Workshop Fabrikasi Logam MBE',
            'slug' => 'ekspansi-workshop-fabrikasi-logam-mbe',
            'published_at' => '2026-10-21',
            'content' => '<p>PT Makmur Bersama Enjiniring melakukan ekspansi workshop fabrikasi logam untuk memperbesar kapasitas produksi.</p><h2>Kapasitas Mesin Baru</h2><p>'.str_repeat('keterangan operasional ', 40).'</p><a href="/layanan">Lihat Layanan</a>',
            'excerpt' => 'PT MBE memperluas area workshop.',
            'focus_keyword' => 'Fabrikasi Logam',
            'meta_title' => 'Ekspansi Workshop Fabrikasi Logam MBE 2026',
            'meta_description' => 'PT Makmur Bersama Enjiniring memperluas workshop fabrikasi logam dengan penambahan mesin berteknologi presisi tinggi untuk industri.',
            'image_alt' => 'Gedung workshop fabrikasi logam baru PT Makmur Bersama Enjiniring',
        ]);

        $response->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseHas('news', [
            'slug' => 'ekspansi-workshop-fabrikasi-logam-mbe',
            'focus_keyword' => 'Fabrikasi Logam',
            'meta_title' => 'Ekspansi Workshop Fabrikasi Logam MBE 2026',
            'image_alt' => 'Gedung workshop fabrikasi logam baru PT Makmur Bersama Enjiniring',
        ]);

        $news = News::where('slug', 'ekspansi-workshop-fabrikasi-logam-mbe')->first();
        $this->assertNotNull($news);
        $this->assertGreaterThan(0, $news->seo_score);
        $this->assertLessThanOrEqual(100, $news->seo_score);
    }

    public function test_updating_seo_fields_recalculates_score_server_side(): void
    {
        $this->authenticateAdmin();

        $news = News::create([
            'title' => 'Judul Awal Berita',
            'slug' => 'judul-awal-berita',
            'published_at' => now(),
            'content' => '<p>Konten awal yang pendek.</p>',
            'seo_score' => 10,
        ]);

        $response = $this->put(route('admin.news.update', $news->id), [
            'title' => 'Peningkatan Kapasitas CNC Machining Presisi MBE',
            'slug' => 'peningkatan-kapasitas-cnc-machining-presisi-mbe',
            'published_at' => '2026-10-21',
            'content' => '<p>Peningkatan kapasitas CNC Machining presisi kami memungkinkan produksi komponen dengan kecepatan dua kali lipat.</p><h2>Fasilitas Baru CNC</h2><p>'.str_repeat('pabrikasi presisi komponen ', 50).'</p><a href="/produk">Katalog Produk</a>',
            'focus_keyword' => 'CNC Machining',
            'meta_title' => 'Peningkatan Kapasitas CNC Machining Presisi MBE 2026',
            'meta_description' => 'MBE meningkatkan kapasitas produksi CNC Machining presisi untuk mendukung pengadaan komponen permesinan industri berstandar internasional.',
            'image_alt' => 'Mesin CNC machining baru beroperasi di bengkel kerja PT MBE',
        ]);

        $response->assertRedirect(route('admin.news.index'));

        $news->refresh();
        $this->assertEquals('CNC Machining', $news->focus_keyword);
        $this->assertGreaterThan(60, $news->seo_score);
    }

    public function test_existing_article_without_seo_fields_preserved(): void
    {
        $news = News::create([
            'title' => 'Berita Lama Tanpa SEO Khusus',
            'slug' => 'berita-lama-tanpa-seo-khusus',
            'published_at' => now(),
            'content' => '<p>Isi artikel berita lawas.</p>',
        ]);

        $this->assertNull($news->focus_keyword);
        $this->assertNull($news->meta_title);
        $this->assertNull($news->image_alt);
        $this->assertIsInt($news->seo_score);

        // Status should be incomplete
        $status = $news->seo_status;
        $this->assertEquals('#64748b', $status['color']);
    }

    public function test_ajax_analyze_seo_endpoint_returns_json_analysis(): void
    {
        $this->authenticateAdmin();

        $response = $this->postJson(route('admin.news.analyze-seo'), [
            'title' => 'Uji Coba Analisis SEO Realtime Berita MBE',
            'meta_title' => 'Uji Coba Analisis SEO Realtime Berita MBE 2026',
            'focus_keyword' => 'Analisis SEO',
            'slug' => 'uji-coba-analisis-seo-realtime',
            'meta_description' => 'Deskripsi meta pengujian yang mencukupi standar panjang karakter Google search console untuk artikel berita industri fabrikasi.',
            'content' => '<p>Analisis SEO membantu redaksi membuat konten yang optimal.</p><h2>Pentingnya Analisis SEO</h2><p>'.str_repeat('informasi industri ', 60).'</p><a href="/layanan">Layanan</a>',
            'image' => 'assets/images/sample.jpg',
            'image_alt' => 'Tampilan panel analisis SEO Yoast',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'score',
            'max_score',
            'status',
            'status_label',
            'status_color',
            'has_focus_keyword',
            'word_count',
            'checks' => [
                '*' => [
                    'id',
                    'label',
                    'status',
                    'score',
                    'max_score',
                    'explanation',
                    'recommendation',
                ],
            ],
        ]);
    }

    public function test_public_article_page_renders_seo_title_and_description(): void
    {
        $news = News::create([
            'title' => 'Judul Berita Publik',
            'meta_title' => 'Custom SEO Title Khusus Google Mesin Pencari',
            'slug' => 'berita-publik-seo-lengkap',
            'published_at' => now(),
            'focus_keyword' => 'Fabrikasi Cirebon',
            'meta_description' => 'Deskripsi khusus yang ditargetkan untuk tampil pada cuplikan mesin pencari Google.',
            'content' => '<p>Konten artikel lengkap.</p>',
            'image' => 'assets/images/news/foto.jpg',
            'image_alt' => 'Pekerjaan pengelasan fabrikasi Cirebon',
        ]);

        $response = $this->get(route('news.show', $news->slug));

        $response->assertStatus(200);

        // Check <title>
        $response->assertSee('Custom SEO Title Khusus Google Mesin Pencari - PT Makmur Bersama Enjiniring', false);

        // Check <meta name="description">
        $response->assertSee('name="description" content="Deskripsi khusus yang ditargetkan untuk tampil pada cuplikan mesin pencari Google."', false);

        // Check canonical URL
        $response->assertSee('rel="canonical" href="'.route('news.show', $news->slug).'"', false);

        // Check OpenGraph
        $response->assertSee('property="og:type" content="article"', false);
        $response->assertSee('property="og:title" content="Custom SEO Title Khusus Google Mesin Pencari"', false);
        $response->assertSee('property="og:description" content="Deskripsi khusus yang ditargetkan untuk tampil pada cuplikan mesin pencari Google."', false);
        $response->assertSee('property="og:image" content="'.asset('assets/images/news/foto.jpg').'"', false);

        // Check Twitter Card
        $response->assertSee('name="twitter:card" content="summary_large_image"', false);
        $response->assertSee('name="twitter:title" content="Custom SEO Title Khusus Google Mesin Pencari"', false);

        // Check Schema.org JSON-LD
        $response->assertSee('"@type": "NewsArticle"', false);
        $response->assertSee('"headline": "Custom SEO Title Khusus Google Mesin Pencari"', false);

        // Check image alt attribute
        $response->assertSee('alt="Pekerjaan pengelasan fabrikasi Cirebon"', false);
    }

    public function test_public_article_page_falls_back_when_optional_seo_fields_are_empty(): void
    {
        $news = News::create([
            'title' => 'Judul Berita Standar Saja',
            'slug' => 'judul-berita-standar-saja',
            'published_at' => now(),
            'excerpt' => 'Ringkasan singkat dari artikel berita biasa.',
            'content' => '<p>Isi artikel standar tanpa meta khusus.</p>',
        ]);

        $response = $this->get(route('news.show', $news->slug));

        $response->assertStatus(200);
        $response->assertSee('Judul Berita Standar Saja - PT Makmur Bersama Enjiniring', false);
        $response->assertSee('name="description" content="Ringkasan singkat dari artikel berita biasa."', false);
        $response->assertSee('property="og:title" content="Judul Berita Standar Saja"', false);
    }

    public function test_seo_metadata_is_escaped_preventing_xss(): void
    {
        $news = News::create([
            'title' => 'Judul Aman',
            'meta_title' => 'Judul "><script>alert("xss")</script>',
            'slug' => 'judul-xss-test',
            'published_at' => now(),
            'meta_description' => 'Deskripsi "><img src=x onerror=alert(1)>',
            'content' => '<p>Isi artikel.</p>',
        ]);

        $response = $this->get(route('news.show', $news->slug));

        $response->assertStatus(200);
        $response->assertDontSee('<script>alert("xss")</script>', false);
        $response->assertDontSee('<img src=x onerror=alert(1)>', false);
    }

    public function test_validation_fails_when_required_fields_missing(): void
    {
        $this->authenticateAdmin();

        $response = $this->post(route('admin.news.store'), [
            'title' => '',
            'content' => '',
        ]);

        $response->assertSessionHasErrors(['title', 'published_at', 'content']);
    }

    public function test_can_upload_inline_image_for_content(): void
    {
        $this->authenticateAdmin();

        $file = UploadedFile::fake()->image('batu-taman.jpg', 800, 600);

        $response = $this->postJson(route('admin.news.upload-inline-image'), [
            'image' => $file,
            'alt' => 'Batu ocean wave untuk taman',
            'caption' => 'Sumber : Stone Depot',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'alt' => 'Batu ocean wave untuk taman',
            'caption' => 'Sumber : Stone Depot',
        ]);
        $this->assertNotEmpty($response->json('url'));

        // Clean up uploaded fake file from public path if created
        $filename = $response->json('filename');
        if ($filename && file_exists(public_path('assets/images/news/'.$filename))) {
            unlink(public_path('assets/images/news/'.$filename));
        }
    }
}
