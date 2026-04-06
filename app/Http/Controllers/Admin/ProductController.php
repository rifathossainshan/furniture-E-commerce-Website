<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // ─── Helper: upload a single image to public/uploads/{folder} ───────────
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

    // ─── Helper: delete an image from public/ ───────────────────────────────
    private function removeImageFile(?string $path): void
    {
        if ($path && file_exists(public_path($path))) {
            unlink(public_path($path));
        }
    }

    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.form', ['product' => new Product(), 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'    => 'nullable|exists:categories,id',
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'image'          => 'nullable|image|max:4096',
            'images.*'       => 'nullable|image|max:4096',
            'is_featured'    => 'boolean',
            'status'         => 'boolean',
            'meta_title'     => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'  => 'nullable|string',
        ]);

        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'products');
        }

        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $file) {
                $images[] = $this->uploadImage($file, 'products');
            }
            $data['images'] = $images;
        }

        $product = Product::create($data);

        if ($request->has('attributes')) {
            $attributeNames  = $request->input('attributes.name', []);
            $attributeValues = $request->input('attributes.value', []);

            foreach ($attributeNames as $index => $name) {
                if (!empty($name) && !empty($attributeValues[$index])) {
                    $product->attributes()->create([
                        'name'  => $name,
                        'value' => $attributeValues[$index],
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id'    => 'nullable|exists:categories,id',
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'image'          => 'nullable|image|max:4096',
            'images.*'       => 'nullable|image|max:4096',
            'is_featured'    => 'boolean',
            'status'         => 'boolean',
            'meta_title'     => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'  => 'nullable|string',
        ]);

        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('image')) {
            $this->removeImageFile($product->image);   // delete old image
            $data['image'] = $this->uploadImage($request->file('image'), 'products');
        }

        if ($request->hasFile('images')) {
            $images = is_array($product->images) ? $product->images : [];
            foreach ($request->file('images') as $file) {
                $images[] = $this->uploadImage($file, 'products');
            }
            $data['images'] = $images;
        }

        $product->update($data);

        if ($request->has('attributes')) {
            $product->attributes()->delete();

            $attributeNames  = $request->input('attributes.name', []);
            $attributeValues = $request->input('attributes.value', []);

            foreach ($attributeNames as $index => $name) {
                if (!empty($name) && !empty($attributeValues[$index])) {
                    $product->attributes()->create([
                        'name'  => $name,
                        'value' => $attributeValues[$index],
                    ]);
                }
            }
        } else {
            $product->attributes()->delete();
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Delete main image
        $this->removeImageFile($product->image);

        // Delete gallery images
        if (is_array($product->images)) {
            foreach ($product->images as $img) {
                $this->removeImageFile($img);
            }
        }

        // Delete all associated reviews and their image files
        foreach ($product->reviews as $review) {
            foreach ($review->images as $reviewImage) {
                $this->removeImageFile($reviewImage->image);
            }
            $review->delete();
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function destroyImage(Product $product, $index)
    {
        $images = is_array($product->images) ? $product->images : [];
        if (isset($images[$index])) {
            $this->removeImageFile($images[$index]);
            unset($images[$index]);
            $product->update(['images' => array_values($images)]);
        }

        return back()->with('success', 'Image deleted successfully.');
    }
}
