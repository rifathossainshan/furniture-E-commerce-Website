<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('cart', compact('cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);

        // Collect selected attributes from form (e.g. attr_Size => 42, attr_Color => Red)
        $selectedAttributes = [];
        foreach ($request->all() as $key => $val) {
            if (str_starts_with($key, 'attr_') && $val !== '') {
                $attrName = str_replace('attr_', '', $key);
                $selectedAttributes[$attrName] = $val;
            }
        }

        // Create a unique cart key based on product id + selected attributes
        $cartKey = $product->id . (count($selectedAttributes) ? '_' . md5(json_encode($selectedAttributes)) : '');

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity']++;
        } else {
            $cart[$cartKey] = [
                "name"                => $product->name,
                "quantity"            => 1,
                "price"               => $product->price,
                "image"               => $product->image,
                "product_id"          => $product->id,
                "selected_attributes" => $selectedAttributes,
            ];
        }

        session()->put('cart', $cart);
        
        if ($request->buy_now == 1) {
            return redirect()->route('checkout.index');
        }
        
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = max(1, $request->quantity);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Cart updated successfully');
        }
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return redirect()->route('cart.index')->with('success', 'Product removed successfully');
        }
    }
}
