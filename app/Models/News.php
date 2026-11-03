<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    public const CATEGORIES = [
        'CNC' => 'CNC',
        'Fabrikasi' => 'Fabrikasi',
        'Laser Cutting' => 'Laser Cutting',
        'General Trading' => 'General Trading',
        'Bending' => 'Bending',
    ];

    protected $fillable = [
        'title',
        'slug',
        'published_at',
        'status',
        'category',
        'image',
        'image_alt',
        'excerpt',
        'content',
        'is_headline',
        'focus_keyword',
        'secondary_keywords',
        'meta_title',
        'meta_description',
        'seo_score',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_headline' => 'boolean',
        'secondary_keywords' => 'array',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }

            // Sync scheduling status
            if ($model->status !== 'draft') {
                if ($model->published_at && $model->published_at->isFuture()) {
                    $model->status = 'scheduled';
                } else {
                    $model->status = 'published';
                }
            }

            if (!empty($model->content)) {
                $model->content = static::normalizeHtmlLinks($model->content);
            }

            $model->seo_score = static::calculateSeoScore($model);
        });
    }

    public function scopePublished($query)
    {
        return $query->where(function ($q) {
            $q->where('status', 'published')
              ->orWhereNull('status');
        })->where(function ($q) {
            $q->whereNull('published_at')
              ->orWhere('published_at', '<=', now());
        });
    }

    public function isPublished(): bool
    {
        return in_array($this->status, ['published', null])
            && ($this->published_at === null || $this->published_at->lte(now()));
    }

    public function isScheduled(): bool
    {
        return $this->status === 'scheduled' || ($this->published_at && $this->published_at->isFuture());
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public static function calculateSeoScore($model): int
    {
        return app(\App\Services\SeoScoringService::class)->calculateScore($model);
    }

    public function getSeoAnalysisAttribute(): array
    {
        return app(\App\Services\SeoScoringService::class)->analyze($this);
    }

    public function getSeoStatusAttribute(): array
    {
        if (empty($this->focus_keyword)) {
            return ['label' => 'Belum Lengkap (Incomplete)', 'class' => 'badge-seo-incomplete', 'color' => '#64748b'];
        }

        if ($this->seo_score >= 80) {
            return ['label' => 'Bagus (Good)', 'class' => 'badge-seo-good', 'color' => '#00a859'];
        } elseif ($this->seo_score >= 60) {
            return ['label' => 'Perlu Perbaikan (OK)', 'class' => 'badge-seo-ok', 'color' => '#ff9800'];
        } else {
            return ['label' => 'Kurang (Poor)', 'class' => 'badge-seo-poor', 'color' => '#f44336'];
        }
    }

    public function getImageAltOrTitleAttribute(): string
    {
        return ! empty($this->image_alt) ? $this->image_alt : $this->title;
    }

    public function getEffectiveTitleAttribute(): string
    {
        return ! empty($this->meta_title) ? $this->meta_title : $this->title;
    }

    public function getContentAttribute($value): ?string
    {
        return static::normalizeHtmlLinks($value);
    }

    public static function normalizeHtmlLinks(?string $html): ?string
    {
        if (empty($html)) {
            return $html;
        }

        return preg_replace_callback('/<a\s+([^>]*?)href=(["\'])(.*?)\2([^>]*?)>/i', function ($matches) {
            $before = trim($matches[1]);
            $quote = $matches[2];
            $href = trim($matches[3]);
            $after = trim($matches[4]);

            if ($href === '' || str_starts_with($href, '#') || str_starts_with($href, '/') || str_starts_with($href, 'mailto:') || str_starts_with($href, 'tel:') || str_starts_with($href, 'javascript:')) {
                return $matches[0];
            }

            if (!preg_match('/^https?:\/\//i', $href)) {
                $href = 'https://' . $href;
            }

            $allOtherAttrs = ($before ? $before . ' ' : '') . $after;
            $isExternal = !str_contains(strtolower($href), 'makben.co.id');

            if ($isExternal) {
                if (!preg_match('/target=["\'][^"\']*["\']/i', $allOtherAttrs)) {
                    $after .= ' target="_blank"';
                }
                if (!preg_match('/rel=["\'][^"\']*["\']/i', $allOtherAttrs)) {
                    $after .= ' rel="noopener noreferrer"';
                }
            }

            $parts = array_filter([$before, 'href=' . $quote . $href . $quote, trim($after)]);
            return '<a ' . implode(' ', $parts) . '>';
        }, $html);
    }
}
