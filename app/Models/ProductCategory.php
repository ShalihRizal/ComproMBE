<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'product_categories';

    protected $fillable = [
        'name',
        'slug',
        'subtitle',
        'icon',
        'header_img',
        'description',
        'category_name',
        'gallery_folder',
        'sort_order',
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

    public function products()
    {
        return $this->hasMany(Product::class, 'product_category_id')->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
    }

    public function getHeaderImageUrlAttribute()
    {
        if (empty($this->header_img)) {
            return asset('assets/images/page_beranda/foto produk kami fabrikasi.png');
        }

        if (Str::startsWith($this->header_img, ['http://', 'https://'])) {
            return $this->header_img;
        }

        if (Str::startsWith($this->header_img, 'assets/')) {
            return asset($this->header_img);
        }

        return asset('uploads/products/' . $this->header_img);
    }

    public function getIconHtmlAttribute()
    {
        if (empty($this->icon)) {
            return '<i class="fa-solid fa-gears" style="font-size: 0.85rem; width: 18px; color: #0191b3;"></i>';
        }

        if (Str::startsWith($this->icon, ['http://', 'https://']) || Str::contains($this->icon, ['.png', '.jpg', '.jpeg', '.svg', '.webp', '/'])) {
            $url = Str::startsWith($this->icon, ['http://', 'https://']) 
                ? $this->icon 
                : asset(Str::startsWith($this->icon, ['uploads/', 'assets/']) ? $this->icon : 'uploads/products/' . $this->icon);
            
            return '<img src="' . $url . '" alt="' . e($this->name) . '" style="width: 18px; height: 18px; object-fit: contain; vertical-align: middle; margin-right: 6px;">';
        }

        return '<i class="' . e($this->icon) . '" style="font-size: 0.85rem; width: 18px; color: #0191b3;"></i>';
    }
}
