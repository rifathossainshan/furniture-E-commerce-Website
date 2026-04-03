<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    public function create()
    {
        $products = Product::where('status', true)->get();
        return view('admin.reviews.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:2000'],
            'review_date' => ['nullable', 'date'],
            'images' => ['nullable', 'array', 'max:3'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $review = Review::create([
            'product_id' => $request->product_id,
            'customer_name' => $request->customer_name,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'approved',
            'is_admin_added' => true,
            'review_date' => $request->review_date,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('reviews', 'public');

                $review->images()->create([
                    'image' => $path,
                ]);
            }
        }

        return redirect()->route('admin.reviews.index')->with('success', 'Manual review added successfully.');
    }

    public function index()
    {
        $reviews = Review::with(['product', 'user', 'images'])
            ->latest()
            ->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update([
            'status' => 'approved',
        ]);

        return back()->with('success', 'Review approved.');
    }

    public function reject(Review $review)
    {
        $review->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Review rejected.');
    }

    public function reply(Request $request, Review $review)
    {
        $request->validate([
            'admin_reply' => ['required', 'string', 'max:2000'],
        ]);

        $review->update([
            'admin_reply' => $request->admin_reply,
            'replied_at' => now(),
        ]);

        return back()->with('success', 'Reply added successfully.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Review deleted successfully.');
    }
}
