<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (count($cart) == 0) {
            return redirect()->route('shop')->with('error', 'Your cart is empty.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $discount = 0;
        $voucherCode = session()->get('voucher_code');
        if ($voucherCode) {
            $voucher = Voucher::where('code', $voucherCode)->where('status', true)->first();
            if ($voucher && (!$voucher->expiry_date || $voucher->expiry_date >= now())) {
                if ($voucher->type == 'fixed') {
                    $discount = min($voucher->amount, $subtotal);
                } else {
                    $discount = $subtotal * ($voucher->amount / 100);
                }
            } else {
                session()->forget(['voucher_code', 'discount']);
            }
        }

        $total = max(0, $subtotal - $discount);
        $isBooking = session('is_booking', false);

        return view('checkout', compact('cart', 'subtotal', 'discount', 'total', 'isBooking'));
    }

    public function applyVoucher(Request $request)
    {
        $request->validate(['code' => 'required|string']);
        $code = strtoupper($request->code);

        $voucher = Voucher::where('code', $code)->where('status', true)->first();

        if (!$voucher || ($voucher->expiry_date && $voucher->expiry_date < now()) || ($voucher->usage_limit && $voucher->used_count >= $voucher->usage_limit)) {
            return redirect()->back()->with('error', 'Invalid or expired voucher code.');
        }

        session()->put('voucher_code', $code);
        return redirect()->back()->with('success', 'Voucher applied successfully!');
    }

    public function store(Request $request)
    {
        $isBooking = session('is_booking', false);

        $rules = [
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
        ];

        if (!$isBooking) {
            $rules['delivery_area'] = 'required|in:inside_dhaka,outside_dhaka';
        }

        $request->validate($rules);

        $cart = session()->get('cart', []);
        if (count($cart) == 0) {
            return redirect()->route('shop');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $discount = 0;
        $voucher = null;
        $voucherCode = session()->get('voucher_code');
        if ($voucherCode) {
            $voucher = Voucher::where('code', $voucherCode)->where('status', true)->first();
            if ($voucher && (!$voucher->expiry_date || $voucher->expiry_date >= now())) {
                $discount = $voucher->type == 'fixed' ? min($voucher->amount, $subtotal) : $subtotal * ($voucher->amount / 100);
                $voucher->increment('used_count');
            }
        }

        if ($isBooking) {
            $deliveryCharge = 0;
            $areaText = 'Booking / N/A';
        } else {
            $deliveryCharge = $request->delivery_area === 'inside_dhaka' ? 70 : 130;
            $areaText = $request->delivery_area === 'inside_dhaka' ? 'Inside Dhaka' : 'Outside Dhaka';
        }

        $total = max(0, $subtotal - $discount) + $deliveryCharge;
        $shippingAddress = "{$request->name} - {$request->address} - {$areaText} - Phone: {$request->phone}";

        $order = Order::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'order_number' => ($isBooking ? 'BKG-' : 'ORD-') . strtoupper(Str::random(8)),
            'total_amount' => $subtotal,
            'discount_amount' => $discount,
            'delivery_charge' => $deliveryCharge,
            'final_amount' => $total,
            'status' => 'pending',
            'shipping_address' => $shippingAddress,
            'payment_method' => 'cod'
        ]);

        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id'            => $order->id,
                'product_id'          => $item['product_id'] ?? $id,
                'quantity'            => $item['quantity'],
                'price'               => $item['price'],
                'selected_attributes' => !empty($item['selected_attributes']) ? $item['selected_attributes'] : null,
            ]);

            Product::where('id', $item['product_id'] ?? $id)->decrement('stock', $item['quantity']);
        }

        session()->forget(['cart', 'voucher_code', 'is_booking']);

        return redirect()->route('order.invoice', $order)->with('success', ($isBooking ? 'Booking confirmed successfully! Booking #' : 'Order placed successfully! Order #') . $order->order_number);
    }
}
