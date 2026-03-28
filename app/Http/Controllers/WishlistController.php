<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = session()->get('wishlist', []);
        return view('wishlist', compact('wishlist'));
    }

    public function add(Request $request, Product $product)
    {
        $wishlist = session()->get('wishlist', []);

        if (!isset($wishlist[$product->id])) {
            $wishlist[$product->id] = [
                "name" => $product->name,
                "price" => $product->price,
                "image" => $product->image,
                "product_id" => $product->id,
                "slug" => $product->slug
            ];
            session()->put('wishlist', $wishlist);
            return redirect()->back()->with('success', 'Product added to wishlist!');
        }

        return redirect()->back()->with('success', 'Product is already in your wishlist.');
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $wishlist = session()->get('wishlist', []);
            if (isset($wishlist[$request->id])) {
                unset($wishlist[$request->id]);
                session()->put('wishlist', $wishlist);
            }
            return redirect()->back()->with('success', 'Product removed from wishlist!');
        }
    }
}
