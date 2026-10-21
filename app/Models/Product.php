<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'product_category_id',
        'name',
        'slug',
        'specs',
        'image',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function getImageUrlAttribute()
    {
        if (empty($this->image)) {
            return asset('assets/images/page_beranda/foto produk kami fabrikasi.png');
        }

        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        if (Str::startsWith($this->image, 'assets/')) {
            return asset($this->image);
        }

        if (Str::contains($this->image, '/')) {
            return asset('assets/images/' . $this->image);
        }

        // If gallery_folder exists on category, prepend it
        if ($this->category && !empty($this->category->gallery_folder)) {
            return asset('assets/images/' . $this->category->gallery_folder . '/' . $this->image);
        }

        return asset('uploads/products/' . $this->image);
    }
}
