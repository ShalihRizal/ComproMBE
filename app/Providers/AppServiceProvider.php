<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\ProductCategory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Share product categories across public layouts for dynamic dropdown menu
        View::composer('layouts.app', function ($view) {
            $navCategories = ProductCategory::orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();
            $view->with('navCategories', $navCategories);
        });
    }
}
