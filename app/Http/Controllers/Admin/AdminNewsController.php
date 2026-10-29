<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminNewsController extends Controller
{
    private function checkAuth()
    {
        if (! session('admin_logged_in')) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function index()
    {
        $this->checkAuth();
        $news = News::orderBy('published_at', 'desc')->paginate(10);

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $this->checkAuth();

        return view('admin.news.form');
    }

    public function store(Request $request)
    {
        $this->checkAuth();

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'published_at' => 'required|date',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_alt' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'focus_keyword' => 'nullable|string|max:150',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'_'.Str::slug($file->getClientOriginalName()).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/images/news'), $filename);
            $imagePath = 'assets/images/news/'.$filename;
        }

        // Generate unique slug
        $baseSlug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->title);
        $slug = $baseSlug ?: 'berita-'.time();
        $counter = 1;
        while (News::where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter++;
        }

        // If marked as headline, uncheck existing headlines if needed or set true
        if ($request->has('is_headline')) {
            News::where('is_headline', true)->update(['is_headline' => false]);
        }

        $news = new News;
        $news->title = $request->title;
        $news->slug = $slug;
        $news->published_at = $request->published_at;
        $news->image = $imagePath;
        $news->image_alt = $request->image_alt;
        $news->excerpt = $request->excerpt ?? Str::limit(strip_tags($request->content), 150);
        $news->content = $request->content;
        $news->is_headline = $request->has('is_headline');
        $news->focus_keyword = $request->focus_keyword;
        $news->meta_title = $request->meta_title ?? $request->title;
        $news->meta_description = $request->meta_description ?? Str::limit(strip_tags($request->content), 150);
        $news->save();

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diterbitkan!');
    }

    public function edit($id)
    {
        $this->checkAuth();
        $news = News::findOrFail($id);

        return view('admin.news.form', compact('news'));
    }

    public function update(Request $request, $id)
    {
        $this->checkAuth();
        $news = News::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'published_at' => 'required|date',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_alt' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'focus_keyword' => 'nullable|string|max:150',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'_'.Str::slug($file->getClientOriginalName()).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/images/news'), $filename);
            $news->image = 'assets/images/news/'.$filename;
        }

        // Generate unique slug
        $baseSlug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->title);
        $slug = $baseSlug ?: 'berita-'.time();
        $counter = 1;
        while (News::where('slug', $slug)->where('id', '!=', $news->id)->exists()) {
            $slug = $baseSlug.'-'.$counter++;
        }

        if ($request->has('is_headline') && ! $news->is_headline) {
            News::where('is_headline', true)->update(['is_headline' => false]);
        }

        $news->title = $request->title;
        $news->slug = $slug;
        $news->published_at = $request->published_at;
        $news->image_alt = $request->image_alt;
        $news->excerpt = $request->excerpt ?? Str::limit(strip_tags($request->content), 150);
        $news->content = $request->content;
        $news->is_headline = $request->has('is_headline');
        $news->focus_keyword = $request->focus_keyword;
        $news->meta_title = $request->meta_title ?? $request->title;
        $news->meta_description = $request->meta_description ?? Str::limit(strip_tags($request->content), 150);
        $news->save();

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function analyzeSeo(Request $request)
    {
        $this->checkAuth();

        $analysis = app(\App\Services\SeoScoringService::class)->analyze($request->all());

        return response()->json($analysis);
    }

    public function uploadInlineImage(Request $request)
    {
        $this->checkAuth();

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'alt' => 'nullable|string|max:255',
            'caption' => 'nullable|string|max:255',
        ]);

        $file = $request->file('image');
        $filename = 'inline_'.time().'_'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'.'.$file->getClientOriginalExtension();
        $file->move(public_path('assets/images/news'), $filename);
        $url = asset('assets/images/news/'.$filename);

        return response()->json([
            'success' => true,
            'url' => $url,
            'filename' => $filename,
            'alt' => $request->alt ?: pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'caption' => $request->caption,
        ]);
    }

    public function destroy($id)
    {
        $this->checkAuth();
        $news = News::findOrFail($id);
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Berita telah dihapus.');
    }

    public function toggleHeadline($id)
    {
        $this->checkAuth();
        $news = News::findOrFail($id);

        if (! $news->is_headline) {
            News::where('is_headline', true)->update(['is_headline' => false]);
            $news->is_headline = true;
        } else {
            $news->is_headline = false;
        }
        $news->save();

        return redirect()->back()->with('success', 'Status headline berhasil diperbarui!');
    }
}
