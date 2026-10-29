<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Support\Str;

class SeoScoringService
{
    /**
     * Weighting for each check (total 100 points).
     */
    protected array $weights = [
        'title_length' => 10,
        'keyword_in_title' => 10,
        'meta_description_length' => 10,
        'keyword_in_slug' => 10,
        'content_length' => 10,
        'keyword_in_first_paragraph' => 10,
        'heading_structure' => 10,
        'featured_image' => 10,
        'internal_links' => 10,
        'keyword_density' => 10,
    ];

    /**
     * Analyze news data and return score, status, and structured check results.
     *
     * @param  array<string, mixed>|News  $data
     * @return array<string, mixed>
     */
    public function analyze(array|News $data): array
    {
        $normalized = $this->extractFields($data);

        $checks = [
            $this->checkTitleLength($normalized),
            $this->checkKeywordInTitle($normalized),
            $this->checkMetaDescriptionLength($normalized),
            $this->checkKeywordInSlug($normalized),
            $this->checkContentLength($normalized),
            $this->checkKeywordInFirstParagraph($normalized),
            $this->checkHeadingStructure($normalized),
            $this->checkFeaturedImage($normalized),
            $this->checkInternalLinks($normalized),
            $this->checkKeywordDensity($normalized),
        ];

        $totalScore = 0;
        foreach ($checks as $check) {
            $totalScore += $check['score'];
        }

        $score = max(0, min(100, (int) round($totalScore)));
        $hasKeyword = ! empty($normalized['focus_keyword']);

        [$statusKey, $statusLabel, $statusColor] = $this->resolveStatusMeta($score, $hasKeyword);

        return [
            'score' => $score,
            'max_score' => 100,
            'status' => $statusKey,
            'status_label' => $statusLabel,
            'status_color' => $statusColor,
            'has_focus_keyword' => $hasKeyword,
            'word_count' => $normalized['word_count'],
            'checks' => $checks,
        ];
    }

    /**
     * Quick helper to calculate just the integer score (0-100).
     */
    public function calculateScore(array|News $data): int
    {
        return $this->analyze($data)['score'];
    }

    /**
     * Normalize input into an associative array with clean attributes.
     *
     * @param  array<string, mixed>|News  $data
     * @return array<string, mixed>
     */
    protected function extractFields(array|News $data): array
    {
        if ($data instanceof News) {
            $title = (string) ($data->title ?? '');
            $metaTitle = (string) ($data->meta_title ?? '');
            $metaDescription = (string) ($data->meta_description ?? '');
            $focusKeyword = (string) ($data->focus_keyword ?? '');
            $slug = (string) ($data->slug ?? '');
            $content = (string) ($data->content ?? '');
            $image = (string) ($data->image ?? '');
            $imageAlt = (string) ($data->image_alt ?? '');
        } else {
            $title = (string) ($data['title'] ?? '');
            $metaTitle = (string) ($data['meta_title'] ?? '');
            $metaDescription = (string) ($data['meta_description'] ?? '');
            $focusKeyword = (string) ($data['focus_keyword'] ?? '');
            $slug = (string) ($data['slug'] ?? '');
            $content = (string) ($data['content'] ?? '');
            $image = (string) ($data['image'] ?? '');
            $imageAlt = (string) ($data['image_alt'] ?? '');
        }

        $effectiveTitle = trim($metaTitle !== '' ? $metaTitle : $title);
        $cleanContent = $this->sanitizeHtml($content);
        $wordCount = $this->countWords($cleanContent);

        return [
            'title' => trim($title),
            'meta_title' => trim($metaTitle),
            'effective_title' => $effectiveTitle,
            'meta_description' => trim($metaDescription),
            'focus_keyword' => trim($focusKeyword),
            'slug' => trim($slug !== '' ? $slug : Str::slug($title)),
            'raw_content' => $content,
            'clean_content' => $cleanContent,
            'word_count' => $wordCount,
            'image' => trim($image),
            'image_alt' => trim($imageAlt),
        ];
    }

    /**
     * Check 1: SEO Title exists and has a suitable length (35-65 chars).
     */
    protected function checkTitleLength(array $d): array
    {
        $id = 'title_length';
        $max = $this->weights[$id];
        $len = mb_strlen($d['effective_title']);

        if ($len >= 35 && $len <= 65) {
            return [
                'id' => $id,
                'label' => 'Panjang SEO Title',
                'status' => 'passed',
                'score' => $max,
                'max_score' => $max,
                'explanation' => "Panjang judul SEO sangat baik ({$len} karakter). Tampil optimal di hasil pencarian Google tanpa terpotong.",
                'recommendation' => 'Pertahankan panjang judul pada rentang 35–65 karakter.',
            ];
        }

        if (($len >= 20 && $len < 35) || ($len > 65 && $len <= 75)) {
            $advice = $len < 35 ? 'Judul agak pendek, manfaatkan ruang lebih untuk kata kunci pendukung.' : 'Judul agak panjang dan berisiko terpotong pada layar ponsel.';

            return [
                'id' => $id,
                'label' => 'Panjang SEO Title',
                'status' => 'warning',
                'score' => (int) round($max * 0.5),
                'max_score' => $max,
                'explanation' => "Panjang judul SEO {$len} karakter. {$advice}",
                'recommendation' => 'Sesuaikan panjang judul menjadi antara 35 hingga 65 karakter.',
            ];
        }

        return [
            'id' => $id,
            'label' => 'Panjang SEO Title',
            'status' => 'failed',
            'score' => 0,
            'max_score' => $max,
            'explanation' => $len === 0
                ? 'SEO Title belum diisi.'
                : "Panjang judul SEO tidak optimal ({$len} karakter), terlalu pendek atau melebihi batas tampilan mesin pencari.",
            'recommendation' => 'Tulis judul yang menarik dengan panjang antara 35–65 karakter.',
        ];
    }

    /**
     * Check 2: Focus keyword appears in SEO Title.
     */
    protected function checkKeywordInTitle(array $d): array
    {
        $id = 'keyword_in_title';
        $max = $this->weights[$id];
        $kw = $d['focus_keyword'];

        if ($kw === '') {
            return [
                'id' => $id,
                'label' => 'Kata Kunci di SEO Title',
                'status' => 'failed',
                'score' => 0,
                'max_score' => $max,
                'explanation' => 'Focus keyword belum ditentukan.',
                'recommendation' => 'Masukkan focus keyword untuk menganalisis keberadaan kata kunci pada judul.',
            ];
        }

        if ($this->textContainsPhrase($d['effective_title'], $kw)) {
            return [
                'id' => $id,
                'label' => 'Kata Kunci di SEO Title',
                'status' => 'passed',
                'score' => $max,
                'max_score' => $max,
                'explanation' => "Focus keyword \"{$kw}\" berhasil ditemukan di dalam judul SEO.",
                'recommendation' => 'Bagus! Kata kunci berada di judul utama.',
            ];
        }

        return [
            'id' => $id,
            'label' => 'Kata Kunci di SEO Title',
            'status' => 'failed',
            'score' => 0,
            'max_score' => $max,
            'explanation' => "Focus keyword \"{$kw}\" tidak ditemukan di dalam judul SEO.",
            'recommendation' => "Sertakan focus keyword \"{$kw}\" pada judul artikel atau Meta Title.",
        ];
    }

    /**
     * Check 3: Meta description exists and has suitable length (110-165 chars).
     */
    protected function checkMetaDescriptionLength(array $d): array
    {
        $id = 'meta_description_length';
        $max = $this->weights[$id];
        $len = mb_strlen($d['meta_description']);

        if ($len >= 110 && $len <= 165) {
            return [
                'id' => $id,
                'label' => 'Panjang Meta Description',
                'status' => 'passed',
                'score' => $max,
                'max_score' => $max,
                'explanation' => "Panjang meta description sangat baik ({$len} karakter). Memberikan ringkasan yang jelas untuk cuplikan hasil pencarian.",
                'recommendation' => 'Pertahankan deskripsi pada kisaran 110–165 karakter.',
            ];
        }

        if (($len >= 70 && $len < 110) || ($len > 165 && $len <= 190)) {
            $reason = $len < 110 ? 'Deskripsi agak singkat.' : 'Deskripsi agak panjang dan berpotensi terpotong tanda elipsis (...) di Google.';

            return [
                'id' => $id,
                'label' => 'Panjang Meta Description',
                'status' => 'warning',
                'score' => (int) round($max * 0.5),
                'max_score' => $max,
                'explanation' => "Panjang meta description {$len} karakter. {$reason}",
                'recommendation' => 'Optimalkan panjang deskripsi antara 110 hingga 165 karakter.',
            ];
        }

        return [
            'id' => $id,
            'label' => 'Panjang Meta Description',
            'status' => 'failed',
            'score' => 0,
            'max_score' => $max,
            'explanation' => $len === 0
                ? 'Meta description belum diisi.'
                : "Panjang meta description ({$len} karakter) belum memenuhi standar ringkasan pencarian.",
            'recommendation' => 'Buat ringkasan artikel informatif sepanjang 110–165 karakter.',
        ];
    }

    /**
     * Check 4: Focus keyword appears in URL slug.
     */
    protected function checkKeywordInSlug(array $d): array
    {
        $id = 'keyword_in_slug';
        $max = $this->weights[$id];
        $kw = $d['focus_keyword'];

        if ($kw === '') {
            return [
                'id' => $id,
                'label' => 'Kata Kunci di URL Slug',
                'status' => 'failed',
                'score' => 0,
                'max_score' => $max,
                'explanation' => 'Focus keyword belum ditentukan.',
                'recommendation' => 'Tentukan focus keyword agar dapat diperiksa kecocokannya dengan URL slug.',
            ];
        }

        $kwSlug = Str::slug($kw);
        $urlSlug = Str::slug($d['slug']);

        if ($kwSlug !== '' && str_contains($urlSlug, $kwSlug)) {
            return [
                'id' => $id,
                'label' => 'Kata Kunci di URL Slug',
                'status' => 'passed',
                'score' => $max,
                'max_score' => $max,
                'explanation' => "URL slug \"{$d['slug']}\" memuat kata kunci fokus dengan rapi.",
                'recommendation' => 'URL slug ramah SEO dan mudah dibaca.',
            ];
        }

        return [
            'id' => $id,
            'label' => 'Kata Kunci di URL Slug',
            'status' => 'failed',
            'score' => 0,
            'max_score' => $max,
            'explanation' => "Focus keyword \"{$kw}\" tidak termuat dalam URL slug artikel (\"{$d['slug']}\").",
            'recommendation' => "Gunakan kata kunci pada slug URL (contoh: {$kwSlug}).",
        ];
    }

    /**
     * Check 5: Content meets minimum length (>= 300 words).
     */
    protected function checkContentLength(array $d): array
    {
        $id = 'content_length';
        $max = $this->weights[$id];
        $words = $d['word_count'];

        if ($words >= 300) {
            return [
                'id' => $id,
                'label' => 'Panjang Teks Artikel',
                'status' => 'passed',
                'score' => $max,
                'max_score' => $max,
                'explanation' => "Jumlah kata dalam artikel sangat memadai ({$words} kata, target >= 300 kata).",
                'recommendation' => 'Panjang artikel sudah mendalam dan informatif bagi pembaca.',
            ];
        }

        if ($words >= 150) {
            return [
                'id' => $id,
                'label' => 'Panjang Teks Artikel',
                'status' => 'warning',
                'score' => (int) round($max * 0.5),
                'max_score' => $max,
                'explanation' => "Artikel memiliki {$words} kata. Ini cukup, namun disarankan minimal 300 kata untuk penjelasan yang lebih bernilai.",
                'recommendation' => 'Tambahkan ulasan atau detail teknis tambahan hingga mencapai setidaknya 300 kata.',
            ];
        }

        return [
            'id' => $id,
            'label' => 'Panjang Teks Artikel',
            'status' => 'failed',
            'score' => 0,
            'max_score' => $max,
            'explanation' => $words === 0
                ? 'Isi artikel masih kosong.'
                : "Artikel terlalu pendek ({$words} kata). Mesin pencari menyukai artikel yang berbobot.",
            'recommendation' => 'Tulis artikel dengan isi minimal 150–300 kata.',
        ];
    }

    /**
     * Check 6: Focus keyword appears naturally in the opening paragraph.
     */
    protected function checkKeywordInFirstParagraph(array $d): array
    {
        $id = 'keyword_in_first_paragraph';
        $max = $this->weights[$id];
        $kw = $d['focus_keyword'];

        if ($kw === '') {
            return [
                'id' => $id,
                'label' => 'Kata Kunci di Paragraf Pembuka',
                'status' => 'failed',
                'score' => 0,
                'max_score' => $max,
                'explanation' => 'Focus keyword belum ditentukan.',
                'recommendation' => 'Tentukan focus keyword untuk memeriksa paragraf awal.',
            ];
        }

        $firstParagraph = $this->extractFirstParagraph($d['raw_content'], $d['clean_content']);

        if ($this->textContainsPhrase($firstParagraph, $kw)) {
            return [
                'id' => $id,
                'label' => 'Kata Kunci di Paragraf Pembuka',
                'status' => 'passed',
                'score' => $max,
                'max_score' => $max,
                'explanation' => "Focus keyword \"{$kw}\" hadir pada paragraf pertama artikel.",
                'recommendation' => 'Bagus! Pembaca dan mesin pencari langsung mengenali topik utama sejak awal.',
            ];
        }

        return [
            'id' => $id,
            'label' => 'Kata Kunci di Paragraf Pembuka',
            'status' => 'failed',
            'score' => 0,
            'max_score' => $max,
            'explanation' => "Focus keyword \"{$kw}\" tidak ditemukan di paragraf pertama artikel.",
            'recommendation' => "Sebutkan kata kunci \"{$kw}\" secara alami pada 1-2 kalimat awal paragraf pertama.",
        ];
    }

    /**
     * Check 7: Heading structure (H2 or H3 present).
     */
    protected function checkHeadingStructure(array $d): array
    {
        $id = 'heading_structure';
        $max = $this->weights[$id];
        $raw = $d['raw_content'];

        preg_match_all('/<h([2-3])[^>]*>(.*?)<\/h\1>/is', $raw, $matches);
        $count = count($matches[0] ?? []);

        if ($count > 0) {
            $hasKeywordInHeading = false;
            if ($d['focus_keyword'] !== '') {
                foreach ($matches[2] as $headingText) {
                    if ($this->textContainsPhrase(strip_tags($headingText), $d['focus_keyword'])) {
                        $hasKeywordInHeading = true;
                        break;
                    }
                }
            }

            if ($hasKeywordInHeading) {
                return [
                    'id' => $id,
                    'label' => 'Struktur Heading (H2/H3)',
                    'status' => 'passed',
                    'score' => $max,
                    'max_score' => $max,
                    'explanation' => "Struktur artikel terorganisir dengan {$count} sub-heading dan memuat kata kunci fokus.",
                    'recommendation' => 'Struktur heading sangat baik.',
                ];
            }

            return [
                'id' => $id,
                'label' => 'Struktur Heading (H2/H3)',
                'status' => 'passed',
                'score' => (int) round($max * 0.8),
                'max_score' => $max,
                'explanation' => "Ditemukan {$count} sub-heading (H2/H3). Pertimbangkan menyisipkan kata kunci fokus pada salah satu sub-heading.",
                'recommendation' => 'Sisipkan kata kunci fokus pada sub-heading H2 yang relevan untuk poin maksimal.',
            ];
        }

        return [
            'id' => $id,
            'label' => 'Struktur Heading (H2/H3)',
            'status' => 'failed',
            'score' => 0,
            'max_score' => $max,
            'explanation' => 'Artikel belum memiliki sub-heading (H2 atau H3).',
            'recommendation' => 'Gunakan tag <h2> atau <h3> untuk membagi artikel menjadi bagian-bagian yang mudah dibaca.',
        ];
    }

    /**
     * Check 8: Featured image exists with descriptive alt text.
     */
    protected function checkFeaturedImage(array $d): array
    {
        $id = 'featured_image';
        $max = $this->weights[$id];
        $hasImage = $d['image'] !== '';
        $altLen = mb_strlen($d['image_alt']);

        if ($hasImage && $altLen >= 5) {
            return [
                'id' => $id,
                'label' => 'Gambar Utama & Alt Text',
                'status' => 'passed',
                'score' => $max,
                'max_score' => $max,
                'explanation' => "Gambar utama tersedia dan dilengkapi teks alternatif yang deskriptif (\"{$d['image_alt']}\").",
                'recommendation' => 'Alt text gambar sudah informatif untuk aksesibilitas dan Google Image Search.',
            ];
        }

        if ($hasImage && $altLen < 5) {
            return [
                'id' => $id,
                'label' => 'Gambar Utama & Alt Text',
                'status' => 'warning',
                'score' => (int) round($max * 0.5),
                'max_score' => $max,
                'explanation' => 'Gambar utama sudah diunggah, namun teks alternatif (Alt Text) masih kosong atau terlalu singkat.',
                'recommendation' => 'Tuliskan deskripsi ringkas pada kolom Alt Text Gambar untuk membantu peringkat gambar di Google.',
            ];
        }

        return [
            'id' => $id,
            'label' => 'Gambar Utama & Alt Text',
            'status' => 'failed',
            'score' => 0,
            'max_score' => $max,
            'explanation' => 'Artikel belum memiliki gambar utama (featured image).',
            'recommendation' => 'Unggah gambar landscape (16:9) yang relevan dan sertakan teks alt deskriptif.',
        ];
    }

    /**
     * Check 9: Internal links exist in content.
     */
    protected function checkInternalLinks(array $d): array
    {
        $id = 'internal_links';
        $max = $this->weights[$id];
        $raw = $d['raw_content'];

        preg_match_all('/<a\s+[^>]*href=["\']([^"\']+)["\']/is', $raw, $matches);
        $links = $matches[1] ?? [];

        if (empty($links)) {
            return [
                'id' => $id,
                'label' => 'Tautan Internal (Internal Links)',
                'status' => 'failed',
                'score' => 0,
                'max_score' => $max,
                'explanation' => 'Tidak ditemukan tautan internal di dalam artikel.',
                'recommendation' => 'Tambahkan setidaknya satu tautan ke halaman produk, layanan, atau artikel terkait di website ini.',
            ];
        }

        $internalCount = 0;
        foreach ($links as $link) {
            if ($this->isInternalUrl($link)) {
                $internalCount++;
            }
        }

        if ($internalCount > 0) {
            return [
                'id' => $id,
                'label' => 'Tautan Internal (Internal Links)',
                'status' => 'passed',
                'score' => $max,
                'max_score' => $max,
                'explanation' => "Ditemukan {$internalCount} tautan internal yang memperkuat struktur navigasi situs.",
                'recommendation' => 'Struktur tautan internal artikel sudah baik.',
            ];
        }

        return [
            'id' => $id,
            'label' => 'Tautan Internal (Internal Links)',
            'status' => 'warning',
            'score' => (int) round($max * 0.5),
            'max_score' => $max,
            'explanation' => 'Terdapat tautan, namun semuanya mengarah ke domain luar (eksternal).',
            'recommendation' => 'Tambahkan tautan internal yang mengarahkan pembaca ke layanan atau produk PT MBE.',
        ];
    }

    /**
     * Check 10: Natural keyword usage and density (0.5% - 2.5%, no keyword stuffing).
     */
    protected function checkKeywordDensity(array $d): array
    {
        $id = 'keyword_density';
        $max = $this->weights[$id];
        $kw = $d['focus_keyword'];
        $words = $d['word_count'];

        if ($kw === '') {
            return [
                'id' => $id,
                'label' => 'Kepadatan Kata Kunci (Density)',
                'status' => 'failed',
                'score' => 0,
                'max_score' => $max,
                'explanation' => 'Focus keyword belum ditentukan.',
                'recommendation' => 'Tentukan focus keyword untuk menghitung frekuensi penggunaan dalam teks artikel.',
            ];
        }

        if ($words === 0) {
            return [
                'id' => $id,
                'label' => 'Kepadatan Kata Kunci (Density)',
                'status' => 'failed',
                'score' => 0,
                'max_score' => $max,
                'explanation' => 'Isi artikel kosong, tidak dapat menghitung kepadatan kata kunci.',
                'recommendation' => 'Tuliskan isi artikel terlebih dahulu.',
            ];
        }

        $occurrences = $this->countPhraseOccurrences($d['clean_content'], $kw);
        $kwWords = max(1, $this->countWords($kw));
        $density = round(($occurrences * $kwWords / $words) * 100, 2);

        if ($occurrences === 0) {
            return [
                'id' => $id,
                'label' => 'Kepadatan Kata Kunci (Density)',
                'status' => 'failed',
                'score' => 0,
                'max_score' => $max,
                'explanation' => "Kata kunci \"{$kw}\" sama sekali belum digunakan dalam teks artikel (0 kali).",
                'recommendation' => "Gunakan kata kunci \"{$kw}\" secara alami beberapa kali di dalam teks artikel.",
            ];
        }

        if ($density > 3.0) {
            return [
                'id' => $id,
                'label' => 'Kepadatan Kata Kunci (Density)',
                'status' => 'warning',
                'score' => (int) round($max * 0.3),
                'max_score' => $max,
                'explanation' => "Kepadatan kata kunci terlalu tinggi ({$density}%, muncul {$occurrences} kali). Berpotensi dianggap keyword stuffing oleh Google.",
                'recommendation' => 'Kurangi pengulangan kata kunci agar kalimat terdengar alami dan tidak membebani pembaca.',
            ];
        }

        if ($density >= 0.5 && $density <= 3.0) {
            return [
                'id' => $id,
                'label' => 'Kepadatan Kata Kunci (Density)',
                'status' => 'passed',
                'score' => $max,
                'max_score' => $max,
                'explanation' => "Kepadatan kata kunci sangat optimal ({$density}%, muncul {$occurrences} kali dalam {$words} kata).",
                'recommendation' => 'Penggunaan kata kunci seimbang dan natural.',
            ];
        }

        return [
            'id' => $id,
            'label' => 'Kepadatan Kata Kunci (Density)',
            'status' => 'warning',
            'score' => (int) round($max * 0.6),
            'max_score' => $max,
            'explanation' => "Kepadatan kata kunci agak rendah ({$density}%, muncul {$occurrences} kali).",
            'recommendation' => 'Sisipkan kata kunci 1–2 kali lagi di paragraf atau bagian pembahasan yang relevan.',
        ];
    }

    /**
     * Check if a text contains a keyword/phrase safely (case-insensitive & Unicode aware).
     */
    protected function textContainsPhrase(string $text, string $phrase): bool
    {
        $normalizedText = $this->normalizeString($text);
        $normalizedPhrase = $this->normalizeString($phrase);

        if ($normalizedPhrase === '' || $normalizedText === '') {
            return false;
        }

        return str_contains($normalizedText, $normalizedPhrase);
    }

    /**
     * Count how many times a phrase appears in clean text.
     */
    protected function countPhraseOccurrences(string $text, string $phrase): int
    {
        $normalizedText = $this->normalizeString($text);
        $normalizedPhrase = $this->normalizeString($phrase);

        if ($normalizedPhrase === '' || $normalizedText === '') {
            return 0;
        }

        return substr_count($normalizedText, $normalizedPhrase);
    }

    /**
     * Normalize string for reliable comparison (lowercase, trimmed whitespace, unicode).
     */
    protected function normalizeString(string $value): string
    {
        $clean = mb_strtolower($value, 'UTF-8');
        $clean = preg_replace('/\s+/u', ' ', $clean);

        return trim($clean ?? '');
    }

    /**
     * Remove scripts, styles, and HTML tags, decoding entities.
     */
    protected function sanitizeHtml(string $html): string
    {
        $noScripts = preg_replace('/<(script|style)[^>]*?>.*?<\/(script|style)>/is', '', $html);
        $stripped = strip_tags($noScripts ?? '');

        return html_entity_decode($stripped, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Accurately count Unicode words.
     */
    protected function countWords(string $text): int
    {
        if (trim($text) === '') {
            return 0;
        }

        preg_match_all('/\p{L}+[\p{L}\p{N}\p{Pd}]*/u', $text, $matches);

        return count($matches[0] ?? []);
    }

    /**
     * Extract the first paragraph text or first 100 words.
     */
    protected function extractFirstParagraph(string $rawHtml, string $cleanText): string
    {
        if (preg_match('/<p[^>]*>(.*?)<\/p>/is', $rawHtml, $match)) {
            $pText = trim(strip_tags($match[1]));
            if ($pText !== '') {
                return $pText;
            }
        }

        $words = preg_split('/\s+/u', trim($cleanText));
        if (is_array($words) && count($words) > 0) {
            return implode(' ', array_slice($words, 0, 100));
        }

        return $cleanText;
    }

    /**
     * Determine if a URL is internal to the application.
     */
    protected function isInternalUrl(string $url): bool
    {
        $trimmed = trim($url);

        if ($trimmed === '' || str_starts_with($trimmed, '#')) {
            return true;
        }

        if (str_starts_with($trimmed, '/') && ! str_starts_with($trimmed, '//')) {
            return true;
        }

        if (! str_starts_with($trimmed, 'http://') && ! str_starts_with($trimmed, 'https://') && ! str_starts_with($trimmed, 'mailto:') && ! str_starts_with($trimmed, 'tel:')) {
            return true;
        }

        $appHost = parse_url(config('app.url') ?? 'http://localhost', PHP_URL_HOST);
        $linkHost = parse_url($trimmed, PHP_URL_HOST);

        if ($linkHost && $appHost && (str_contains($linkHost, $appHost) || str_contains($appHost, $linkHost))) {
            return true;
        }

        return str_contains($trimmed, 'makben.co.id');
    }

    /**
     * Map numerical score and keyword existence to human labels and colors.
     *
     * @return array{0: string, 1: string, 2: string}
     */
    protected function resolveStatusMeta(int $score, bool $hasKeyword): array
    {
        if (! $hasKeyword) {
            return ['incomplete', 'Analisis Belum Lengkap (Kata Kunci Kosong)', '#64748b'];
        }

        if ($score >= 80) {
            return ['good', 'Bagus (Good SEO)', '#00a859'];
        }

        if ($score >= 60) {
            return ['ok', 'Perlu Perbaikan (OK)', '#ff9800'];
        }

        return ['poor', 'Kurang (Poor SEO)', '#f44336'];
    }
}
