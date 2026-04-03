<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'customer_name' => [Auth::check() ? 'nullable' : 'required', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:2000'],
            'images' => ['nullable', 'array', 'max:3'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $review = Review::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'customer_name' => Auth::check() ? null : $request->customer_name,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'pending',
            'is_admin_added' => false,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('reviews', 'public');

                $review->images()->create([
                    'image' => $path,
                ]);
            }
        }

        return back()->with('success', 'রিভিউ সাবমিট হয়েছে। Admin approve করলে show হবে।');
    }
}
