<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $newsList = News::orderBy('published_at', 'desc')->paginate(9);
        return view('news.index', compact('newsList'));
    }

    public function show($slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();
        $recentNews = News::where('id', '!=', $news->id)->orderBy('published_at', 'desc')->take(3)->get();
        return view('news.show', compact('news', 'recentNews'));
    }
}
