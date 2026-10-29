<?php

use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminProductCategoryController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Web Routes - PT Makmur Bersama Enjiniring (MBE)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang-kami', [ProfileController::class, 'index'])->name('profile');
Route::get('/layanan', [ServiceController::class, 'index'])->name('services');

Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{category}', [ProductController::class, 'show'])->name('products.show');

Route::get('/portofolio', [PortfolioController::class, 'index'])->name('portfolio');

Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/hubungi-kami', [ContactController::class, 'index'])->name('contact');
Route::post('/hubungi-kami', [ContactController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| CMS Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware([\App\Http\Middleware\AdminAuth::class])->group(function () {
        Route::get('/', [AdminNewsController::class, 'index'])->name('dashboard');

        // News CMS
        Route::get('/news', [AdminNewsController::class, 'index'])->name('news.index');
        Route::get('/news/create', [AdminNewsController::class, 'create'])->name('news.create');
        Route::post('/news', [AdminNewsController::class, 'store'])->name('news.store');
        Route::get('/news/{id}/edit', [AdminNewsController::class, 'edit'])->name('news.edit');
        Route::put('/news/{id}', [AdminNewsController::class, 'update'])->name('news.update');
        Route::delete('/news/{id}', [AdminNewsController::class, 'destroy'])->name('news.destroy');
        Route::post('/news/{id}/toggle-headline', [AdminNewsController::class, 'toggleHeadline'])->name('news.toggle-headline');
        Route::post('/news/analyze-seo', [AdminNewsController::class, 'analyzeSeo'])->name('news.analyze-seo');
        Route::post('/news/upload-inline-image', [AdminNewsController::class, 'uploadInlineImage'])->name('news.upload-inline-image');

        // Master Product Categories
        Route::resource('product-categories', AdminProductCategoryController::class);

        // Master Products
        Route::resource('products', AdminProductController::class);
    });
});
