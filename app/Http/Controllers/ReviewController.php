<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\ReviewImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
                // Generate a unique filename
                $fileName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $relativePath = 'uploads/reviews/' . $fileName;

                // Move file directly to public/uploads/reviews
                $image->move(public_path('uploads/reviews'), $fileName);

                $review->images()->create([
                    'image' => $relativePath,
                ]);
            }
        }

        return back()->with('success', 'রিভিউ সাবমিট হয়েছে। Admin approve করলে show হবে।');
    }
}
