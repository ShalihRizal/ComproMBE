<?php

namespace Tests\Feature;

use App\Models\News;
use App\Services\SeoScoringService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_news_as_draft_and_stay_on_editor_page(): void
    {
        $response = $this->withSession(['admin_logged_in' => true])->post(route('admin.news.store'), [
            'title' => 'Artikel Uji Coba Draft Baru',
            'content' => '<p>Konten artikel dalam bentuk draft pengujian.</p>',
            'published_at' => now()->format('Y-m-d\TH:i'),
            'action' => 'draft',
            'stay' => '1',
            'category' => 'CNC',
            'secondary_keywords' => ['machining', 'bubut presisi'],
        ]);

        $news = News::where('title', 'Artikel Uji Coba Draft Baru')->first();
        $this->assertNotNull($news);
        $this->assertEquals('draft', $news->status);
        $this->assertEquals('CNC', $news->category);
        $this->assertContains('machining', $news->secondary_keywords);
        $this->assertContains('bubut presisi', $news->secondary_keywords);

        $response->assertRedirect(route('admin.news.edit', $news->id));
        $response->assertSessionHas('success');
    }

    public function test_draft_and_scheduled_articles_are_hidden_from_public_but_visible_in_admin_preview(): void
    {
        // 1. Create a draft article
        $draft = News::create([
            'title' => 'Berita Rahasia Masih Draft',
            'slug' => 'berita-rahasia-masih-draft',
            'published_at' => now()->subDay(),
            'status' => 'draft',
            'content' => '<p>Konten rahasia belum boleh tayang.</p>',
            'category' => 'Fabrikasi',
        ]);

        // 2. Create a scheduled article
        $scheduled = News::create([
            'title' => 'Berita Terjadwal Masa Depan',
            'slug' => 'berita-terjadwal-masa-depan',
            'published_at' => now()->addDays(5),
            'status' => 'scheduled',
            'content' => '<p>Akan tayang minggu depan secara otomatis.</p>',
            'category' => 'Laser Cutting',
        ]);

        // 3. Create an active published article
        $published = News::create([
            'title' => 'Berita Resmi Sudah Terbit',
            'slug' => 'berita-resmi-sudah-terbit',
            'published_at' => now()->subHours(2),
            'status' => 'published',
            'content' => '<p>Sudah terbit dan siap dibaca publik.</p>',
            'category' => 'CNC',
        ]);

        // Public visitor accessing news list
        $listResponse = $this->get(route('news.index'));
        $listResponse->assertStatus(200);
        $listResponse->assertSee('Berita Resmi Sudah Terbit');
        $listResponse->assertDontSee('Berita Rahasia Masih Draft');
        $listResponse->assertDontSee('Berita Terjadwal Masa Depan');

        // Public visitor accessing draft or scheduled detail directly gets 404
        $this->get(route('news.show', $draft->slug))->assertStatus(404);
        $this->get(route('news.show', $scheduled->slug))->assertStatus(404);

        // Public visitor accessing published detail succeeds
        $this->get(route('news.show', $published->slug))->assertStatus(200);

        // Authenticated admin can preview draft & scheduled articles
        $previewDraft = $this->withSession(['admin_logged_in' => true])->get(route('admin.news.preview', $draft->id));
        $previewDraft->assertStatus(200);
        $previewDraft->assertSee('Berita Rahasia Masih Draft');
        $previewDraft->assertSee('Mode Pratinjau Admin');

        $previewScheduled = $this->withSession(['admin_logged_in' => true])->get(route('admin.news.preview', $scheduled->id));
        $previewScheduled->assertStatus(200);
        $previewScheduled->assertSee('Berita Terjadwal Masa Depan');
    }

    public function test_category_filtering_on_public_news_page(): void
    {
        News::create([
            'title' => 'Artikel Fabrikasi Baja Berat',
            'slug' => 'artikel-fabrikasi-baja-berat',
            'published_at' => now()->subHour(),
            'status' => 'published',
            'content' => '<p>Konten fabrikasi</p>',
            'category' => 'Fabrikasi',
        ]);

        News::create([
            'title' => 'Artikel Mesin Bubut CNC Canggih',
            'slug' => 'artikel-mesin-bubut-cnc-canggih',
            'published_at' => now()->subHour(),
            'status' => 'published',
            'content' => '<p>Konten CNC</p>',
            'category' => 'CNC',
        ]);

        // Filter by CNC
        $cncResponse = $this->get(route('news.index', ['kategori' => 'CNC']));
        $cncResponse->assertStatus(200);
        $cncResponse->assertSee('Artikel Mesin Bubut CNC Canggih');
        $cncResponse->assertDontSee('Artikel Fabrikasi Baja Berat');

        // Filter by Fabrikasi
        $fabResponse = $this->get(route('news.index', ['kategori' => 'Fabrikasi']));
        $fabResponse->assertStatus(200);
        $fabResponse->assertSee('Artikel Fabrikasi Baja Berat');
        $fabResponse->assertDontSee('Artikel Mesin Bubut CNC Canggih');
    }

    public function test_future_datetime_automatically_becomes_scheduled(): void
    {
        $futureTime = Carbon::now('Asia/Jakarta')->addDays(3);

        $response = $this->withSession(['admin_logged_in' => true])->post(route('admin.news.store'), [
            'title' => 'Artikel Masa Depan Terjadwal',
            'content' => '<p>Isi artikel yang dijadwalkan.</p>',
            'published_at' => $futureTime->format('Y-m-d\TH:i'),
            'action' => 'publish', // Even if user clicks publish, future date means scheduled
            'category' => 'Bending',
        ]);

        $news = News::where('title', 'Artikel Masa Depan Terjadwal')->first();
        $this->assertNotNull($news);
        $this->assertEquals('scheduled', $news->status);
        $this->assertTrue($news->isScheduled());
    }

    public function test_seo_service_evaluates_secondary_keywords(): void
    {
        $service = app(SeoScoringService::class);
        $result = $service->analyze([
            'title' => 'Panduan Jasa Fabrikasi Cirebon Terbaik dan Terpercaya',
            'focus_keyword' => 'jasa fabrikasi cirebon',
            'secondary_keywords' => ['machining cnc', 'laser cutting plat', 'piping ducting'],
            'meta_title' => 'Panduan Jasa Fabrikasi Cirebon Terbaik dan Terpercaya',
            'meta_description' => 'Solusi lengkap jasa fabrikasi cirebon dan machining cnc presisi untuk kebutuhan industri Anda.',
            'slug' => 'panduan-jasa-fabrikasi-cirebon-terbaik',
            'content' => '<h2>Layanan Machining CNC</h2><p>Kami melayani jasa fabrikasi cirebon dengan kualitas presisi tinggi. Dukungan teknologi laser cutting plat dan machining cnc modern.</p>',
            'image' => 'assets/images/news/test.jpg',
            'image_alt' => 'jasa fabrikasi cirebon workshop',
        ]);

        $this->assertArrayHasKey('secondary_keywords', $result);
        $this->assertCount(3, $result['secondary_keywords']);

        $sec1 = $result['secondary_keywords'][0];
        $this->assertEquals('machining cnc', $sec1['keyword']);
        $this->assertTrue($sec1['in_content']);
        $this->assertTrue($sec1['in_headings']);
        $this->assertTrue($sec1['in_meta_description']);

        $sec2 = $result['secondary_keywords'][1];
        $this->assertEquals('laser cutting plat', $sec2['keyword']);
        $this->assertTrue($sec2['in_content']);

        $sec3 = $result['secondary_keywords'][2];
        $this->assertEquals('piping ducting', $sec3['keyword']);
        $this->assertFalse($sec3['in_content']);
    }

    public function test_news_content_automatically_normalizes_external_and_relative_links(): void
    {
        $rawHtml = '<p>Kunjungi <a href="google.com">Google Search</a> dan lihat <a href="/layanan">Layanan Kami</a> serta <a href="https://youtube.com">YouTube</a>.</p>';

        $news = News::create([
            'title' => 'Uji Coba Normalisasi Link Otomatis',
            'slug' => 'uji-coba-normalisasi-link-otomatis',
            'published_at' => now(),
            'status' => 'published',
            'content' => $rawHtml,
            'category' => 'CNC',
        ]);

        $content = $news->content;

        // google.com should be prefixed with https:// and have target="_blank" and rel="noopener noreferrer"
        $this->assertStringContainsString('href="https://google.com"', $content);
        $this->assertStringContainsString('target="_blank"', $content);
        $this->assertStringContainsString('rel="noopener noreferrer"', $content);

        // /layanan should remain unchanged
        $this->assertStringContainsString('href="/layanan"', $content);

        // https://youtube.com should have target="_blank" and rel="noopener noreferrer"
        $this->assertStringContainsString('href="https://youtube.com"', $content);
    }
}
