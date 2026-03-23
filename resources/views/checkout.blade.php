@extends('layouts.store')

@section('content')
    <div class="bg-stone-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-serif text-gray-900 tracking-widest uppercase mb-4">Secure Checkout</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-white">
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative mb-6">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative mb-6">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-12">

            <!-- Left Column: Shipping Info -->
            <div class="lg:w-1/2">
                <h3 class="text-xl font-bold text-gray-900 mb-6 uppercase tracking-wider border-b border-gray-200 pb-4">
                    Shipping Details</h3>

                <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Full Name</label>
                            <input type="text" value="{{ auth()->user()->name }}" readonly
                                class="w-full border-gray-300 bg-gray-50 rounded shadow-sm text-gray-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                            <input type="email" value="{{ auth()->user()->email }}" readonly
                                class="w-full border-gray-300 bg-gray-50 rounded shadow-sm text-gray-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Phone Number <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="phone" required
                                class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Street Address <span
                                    class="text-red-500">*</span></label>
                            <textarea name="address" rows="3" required
                                class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900"></textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">City/Region <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="city" required
                                class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                        </div>
                    </div>

                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 uppercase tracking-wider">Payment Method</h3>
                        <div class="border border-gray-300 rounded p-4 bg-stone-50">
                            <label class="flex items-center cursor-pointer text-gray-900 font-medium">
                                <input type="radio" name="payment_method" value="cod" checked
                                    class="text-gray-900 focus:ring-gray-900">
                                <span class="ml-3">Cash on Delivery (COD)</span>
                            </label>
                            <p class="text-sm text-gray-500 mt-2 ml-7">Pay with cash upon delivery.</p>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Right Column: Order Summary -->
            <div class="lg:w-1/2">
                <div class="bg-stone-50 p-6 md:p-8 rounded border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 uppercase tracking-wider border-b border-gray-200 pb-4">
                        In Your Cart</h3>

                    <div class="space-y-4 mb-6">
                        @foreach($cart as $details)
                            <div class="flex justify-between items-center text-sm">
                                <div class="flex items-center gap-4">
                                    @if($details['image'])
                                        <img src="{{ asset('storage/' . $details['image']) }}"
                                            class="w-12 h-16 object-cover rounded border border-gray-200">
                                    @endif
                                    <div>
                                        <h4 class="font-bold text-gray-900">{{ $details['name'] }}</h4>
                                        <p class="text-gray-500">Qty: {{ $details['quantity'] }}</p>
                                    </div>
                                </div>
                                <span
                                    class="font-medium text-gray-900">${{ number_format($details['price'] * $details['quantity'], 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Voucher Form -->
                    <div class="border-y border-gray-200 py-6 mb-6">
                        <form action="{{ route('checkout.voucher') }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="text" name="code" placeholder="Gift card or discount code"
                                value="{{ session('voucher_code') }}"
                                class="flex-1 border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900 text-sm {{ session('voucher_code') ? 'bg-gray-100' : '' }}"
                                {{ session('voucher_code') ? 'readonly' : '' }}>
                            <button type="submit"
                                class="bg-gray-900 text-white font-bold py-2 px-4 rounded hover:bg-black transition text-sm {{ session('voucher_code') ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ session('voucher_code') ? 'disabled' : '' }}>Apply</button>
                        </form>
                    </div>

                    <div class="space-y-3 mb-6 text-sm text-gray-600">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-medium text-gray-900">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        @if($discount > 0)
                            <div class="flex justify-between text-red-600">
                                <span>Discount {{ session('voucher_code') ? '(' . session('voucher_code') . ')' : '' }}</span>
                                <span class="font-medium">-${{ number_format($discount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between border-b border-gray-200 pb-4">
                            <span>Shipping</span>
                            <span class="font-medium text-gray-900">Free</span>
                        </div>
                    </div>

                    <div class="flex justify-between mb-8 text-xl font-bold text-gray-900">
                        <span>Total</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>

                    <button type="button" onclick="document.getElementById('checkout-form').submit();"
                        class="w-full text-center bg-[#d4af37] border border-[#d4af37] hover:bg-[#c19b28] hover:border-[#c19b28] text-white transition font-bold py-4 uppercase tracking-wider shadow-sm disabled:opacity-50">
                        Complete Order
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection