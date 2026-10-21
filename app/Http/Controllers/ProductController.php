<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::orderBy('sort_order', 'asc')->get();
        $category = ProductCategory::where('slug', 'manufaktur')->with('products')->first() ?? $categories->first();

        return view('products.index', compact('category', 'categories'));
    }

    public function show($slug)
    {
        $category = ProductCategory::where('slug', $slug)->with('products')->firstOrFail();
        $categories = ProductCategory::orderBy('sort_order', 'asc')->get();

        return view('products.show', compact('category', 'categories'));
    }
}
