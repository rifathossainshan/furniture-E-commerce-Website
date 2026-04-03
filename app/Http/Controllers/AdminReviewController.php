<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
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
}
