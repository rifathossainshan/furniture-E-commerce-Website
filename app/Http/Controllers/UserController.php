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
}
