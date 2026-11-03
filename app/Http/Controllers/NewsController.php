<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::published()->orderBy('published_at', 'desc');

        if ($request->filled('kategori')) {
            $query->where('category', $request->kategori);
        }

        $newsList = $query->paginate(9)->withQueryString();
        $currentCategory = $request->kategori;
        $categories = News::CATEGORIES;

        return view('news.index', compact('newsList', 'currentCategory', 'categories'));
    }

    public function show(Request $request, $slug)
    {
        $query = News::where('slug', $slug);

        // Allow previewing draft or scheduled articles if admin logged in or preview param present
        if (! session('admin_logged_in') && ! $request->has('preview')) {
            $query->published();
        }

        $news = $query->firstOrFail();

        $recentNews = News::published()
            ->where('id', '!=', $news->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        $isPreview = ! $news->isPublished();

        return view('news.show', compact('news', 'recentNews', 'isPreview'));
    }
}

