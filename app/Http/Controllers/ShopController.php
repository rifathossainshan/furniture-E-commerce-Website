<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->withAvg(['reviews' => function ($query) {
            $query->where('status', 'approved');
        }], 'rating')->where('status', true);

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $products = $query->latest()->paginate(16)->withQueryString();
        $categories = Category::where('status', true)->get();

        return view('shop', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'attributes'])->where('slug', $slug)->where('status', true)->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', true)
            ->withAvg(['reviews' => function ($query) {
                $query->where('status', 'approved');
            }], 'rating')
            ->take(4)->get();

        return view('product', compact('product', 'relatedProducts'));
    }
}
