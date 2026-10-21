<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AdminNewsController extends Controller
{
    private function checkAuth()
    {
        if (!session('admin_logged_in')) {
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
            'published_at' => 'required|date',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/news'), $filename);
            $imagePath = 'assets/images/news/' . $filename;
        }

        // If marked as headline, uncheck existing headlines if needed or set true
        if ($request->has('is_headline')) {
            News::where('is_headline', true)->update(['is_headline' => false]);
        }

        $news = new News();
        $news->title = $request->title;
        $news->slug = Str::slug($request->title);
        $news->published_at = $request->published_at;
        $news->image = $imagePath;
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
            'published_at' => 'required|date',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/news'), $filename);
            $news->image = 'assets/images/news/' . $filename;
        }

        if ($request->has('is_headline') && !$news->is_headline) {
            News::where('is_headline', true)->update(['is_headline' => false]);
        }

        $news->title = $request->title;
        $news->slug = Str::slug($request->title);
        $news->published_at = $request->published_at;
        $news->excerpt = $request->excerpt ?? Str::limit(strip_tags($request->content), 150);
        $news->content = $request->content;
        $news->is_headline = $request->has('is_headline');
        $news->focus_keyword = $request->focus_keyword;
        $news->meta_title = $request->meta_title ?? $request->title;
        $news->meta_description = $request->meta_description ?? Str::limit(strip_tags($request->content), 150);
        $news->save();

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui!');
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
        
        if (!$news->is_headline) {
            News::where('is_headline', true)->update(['is_headline' => false]);
            $news->is_headline = true;
        } else {
            $news->is_headline = false;
        }
        $news->save();

        return redirect()->back()->with('success', 'Status headline berhasil diperbarui!');
    }
}
