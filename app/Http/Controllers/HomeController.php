<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Slider;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('status', true)->get();
        $categories = Category::where('status', true)->get();
        $products = Product::with('category')
            ->withAvg(['reviews' => function ($query) {
                $query->where('status', 'approved');
            }], 'rating')
            ->where('status', true)->latest()->take(8)->get();

        return view('home', compact('sliders', 'categories', 'products'));
    }
    public function about()
    {
        return view('about');
    }
}
