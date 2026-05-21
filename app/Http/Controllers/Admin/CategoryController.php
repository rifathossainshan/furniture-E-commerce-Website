<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // ─── Helper: upload image to public/uploads/{folder} ────────────────────
    private function uploadImage($file, string $folder): string
    {
        $dir = public_path("uploads/{$folder}");
        if (!file_exists($dir)) {
            mkdir($dir, 0775, true);
        }
        $fileName = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $fileName);
        return "uploads/{$folder}/{$fileName}";
    }

    // ─── Helper: delete image from public/ ──────────────────────────────────
    private function deleteImage(?string $path): void
    {
        if ($path && file_exists(public_path($path))) {
            unlink(public_path($path));
        }
    }

    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.form', ['category' => new Category()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'image'  => 'nullable|image|max:2048',
            'status' => 'boolean',
            'text_color' => 'required|in:black,white,red,golden,blue',
        ]);

        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'categories');
        }

        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'image'  => 'nullable|image|max:2048',
            'status' => 'boolean',
            'text_color' => 'required|in:black,white,red,golden,blue',
        ]);

        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('image')) {
            $this->deleteImage($category->image);   // delete old
            $data['image'] = $this->uploadImage($request->file('image'), 'categories');
        }

        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        try {
            $this->deleteImage($category->image);
            $category->delete();
            return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')->with('error', 'Could not delete category: ' . $e->getMessage());
        }
    }
}
