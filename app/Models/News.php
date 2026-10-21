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

    public static function calculateSeoScore($model)
    {
        $score = 0;
        $title = $model->title ?? '';
        $metaDesc = $model->meta_description ?? '';
        $content = strip_tags($model->content ?? '');
        $keyword = strtolower(trim($model->focus_keyword ?? ''));
        $image = $model->image ?? '';

        // 1. Title Length Check (40-60 chars) - 20 pts
        $titleLen = mb_strlen($title);
        if ($titleLen >= 35 && $titleLen <= 65) {
            $score += 20;
        } elseif ($titleLen > 15) {
            $score += 10;
        }

        // 2. Meta Description Check (120-160 chars) - 20 pts
        $descLen = mb_strlen($metaDesc);
        if ($descLen >= 110 && $descLen <= 170) {
            $score += 20;
        } elseif ($descLen > 30) {
            $score += 10;
        }

        // 3. Content Length Check (>= 150 words) - 20 pts
        $wordCount = str_word_count($content);
        if ($wordCount >= 200) {
            $score += 20;
        } elseif ($wordCount >= 80) {
            $score += 10;
        }

        // 4. Focus Keyword Check - 20 pts
        if (!empty($keyword)) {
            $kwInTitle = str_contains(strtolower($title), $keyword);
            $kwInDesc = str_contains(strtolower($metaDesc), $keyword);
            $kwInContent = str_contains(strtolower($content), $keyword);

            if ($kwInTitle && $kwInContent) {
                $score += 20;
            } elseif ($kwInTitle || $kwInContent || $kwInDesc) {
                $score += 10;
            }
        }

        // 5. Featured Image Check - 20 pts
        if (!empty($image)) {
            $score += 20;
        }

        return min(100, $score);
    }

    public function getSeoStatusAttribute()
    {
        if ($this->seo_score >= 80) {
            return ['label' => 'Bagus (Good)', 'class' => 'badge-seo-good', 'color' => '#00a859'];
        } elseif ($this->seo_score >= 50) {
            return ['label' => 'Perlu Perbaikan (OK)', 'class' => 'badge-seo-ok', 'color' => '#ff9800'];
        } else {
            return ['label' => 'Kurang (Poor)', 'class' => 'badge-seo-poor', 'color' => '#f44336'];
        }
    }
}
