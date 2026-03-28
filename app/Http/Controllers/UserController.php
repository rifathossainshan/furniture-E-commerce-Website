<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;

class UserController extends Controller
{
    public function dashboard()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->get();
        return view('user.dashboard', compact('orders'));
    }

    public function invoice(Order $order)
    {
        if ($order->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403, 'Unauthorized access to this invoice');
        }
        
        $order->load('items.product');
        return view('user.invoice', compact('order'));
    }
}
