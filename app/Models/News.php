<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $fillable = [
        'title',
        'slug',
        'published_at',
        'image',
        'image_alt',
        'excerpt',
        'content',
        'is_headline',
        'focus_keyword',
        'meta_title',
        'meta_description',
        'seo_score',
    ];

    protected $casts = [
        'published_at' => 'date',
        'is_headline' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
            $model->seo_score = static::calculateSeoScore($model);
        });
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
}
