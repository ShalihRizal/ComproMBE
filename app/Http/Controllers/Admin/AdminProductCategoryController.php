<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::withCount('products')->orderBy('sort_order', 'asc')->paginate(15);
        return view('admin.product_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.product_categories.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'category_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'icon_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'header_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data = $request->only(['name', 'subtitle', 'icon', 'category_name', 'description']);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('icon_file')) {
            $file = $request->file('icon_file');
            $filename = 'icon_' . time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $data['icon'] = $filename;
        }

        if ($request->hasFile('header_img')) {
            $file = $request->file('header_img');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $data['header_img'] = $filename;
        }

        ProductCategory::create($data);

        return redirect()->route('admin.product-categories.index')->with('success', 'Kategori produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $category = ProductCategory::findOrFail($id);
        return view('admin.product_categories.form', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = ProductCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'category_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'icon_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'header_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data = $request->only(['name', 'subtitle', 'icon', 'category_name', 'description']);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('icon_file')) {
            $file = $request->file('icon_file');
            $filename = 'icon_' . time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $data['icon'] = $filename;
        }

        if ($request->hasFile('header_img')) {
            $file = $request->file('header_img');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $data['header_img'] = $filename;
        }

        $category->update($data);

        return redirect()->route('admin.product-categories.index')->with('success', 'Kategori produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $category = ProductCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.product-categories.index')->with('success', 'Kategori produk berhasil dihapus!');
    }
}
