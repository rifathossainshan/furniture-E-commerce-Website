@extends('layouts.store')

@section('content')
    <div class="bg-stone-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-serif text-gray-900 tracking-widest uppercase mb-4">Shopping Cart</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-white">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(count($cart) > 0)
            <div class="flex flex-col lg:flex-row gap-12">
                <div class="lg:w-2/3">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="py-4 text-xs font-semibold text-gray-500 uppercase tracking-widest">Product</th>
                                <th class="py-4 text-xs font-semibold text-gray-500 uppercase tracking-widest text-center">
                                    Quantity</th>
                                <th class="py-4 text-xs font-semibold text-gray-500 uppercase tracking-widest text-right">Total
                                </th>
                                <th class="py-4 text-xs font-semibold text-gray-500 uppercase tracking-widest text-right"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $id => $details)
                                <tr class="border-b border-gray-100">
                                    <td class="py-6 flex items-center gap-4">
                                        @if($details['image'])
                                            <img src="{{ asset('storage/' . $details['image']) }}"
                                                class="w-20 h-24 object-cover rounded shadow-sm">
                                        @else
                                            <div class="w-20 h-24 bg-stone-200 rounded"></div>
                                        @endif
                                        <div>
                                            <h4 class="font-bold text-gray-900 text-sm mb-1">{{ $details['name'] }}</h4>
                                            <p class="text-gray-500 text-sm">${{ number_format($details['price'], 2) }}</p>
                                        </div>
                                    </td>
                                    <td class="py-6 text-center">
                                        <form action="{{ route('cart.update') }}" method="POST"
                                            class="inline-flex items-center border border-gray-300 rounded overflow-hidden shadow-sm">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1"
                                                class="w-16 border-none text-center text-sm py-1.5 focus:ring-0 appearance-none bg-stone-50"
                                                onchange="this.form.submit()">
                                        </form>
                                    </td>
                                    <td class="py-6 text-right font-bold text-gray-900">
                                        ${{ number_format($details['price'] * $details['quantity'], 2) }}
                                    </td>
                                    <td class="py-6 text-right">
                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <button type="submit" class="text-gray-400 hover:text-red-500 transition">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="lg:w-1/3">
                    <div class="bg-stone-50 p-8 rounded border border-gray-100 shadow-sm">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 uppercase tracking-wider border-b border-gray-200 pb-4">
                            Order Summary</h3>
                        <div class="flex justify-between mb-4 text-sm text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-medium text-gray-900">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between mb-6 text-sm text-gray-600 border-b border-gray-200 pb-6">
                            <span>Shipping</span>
                            <span class="font-medium text-gray-900">Calculated at checkout</span>
                        </div>
                        <div class="flex justify-between mb-8 text-lg font-bold text-gray-900">
                            <span>Total</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>

                        <a href="{{ route('checkout.index') }}"
                            class="block w-full text-center bg-[#d4af37] border border-[#d4af37] hover:bg-[#c19b28] hover:border-[#c19b28] text-white transition text-sm font-bold py-4 uppercase tracking-wider shadow-sm">
                            Proceed to Checkout
                        </a>
                        <a href="{{ route('shop') }}"
                            class="block w-full text-center mt-4 text-gray-500 hover:text-gray-900 transition text-sm uppercase tracking-wider font-semibold">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-20 pb-40">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <h2 class="text-2xl font-serif text-gray-900 mb-4">Your cart is currently empty</h2>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">Explore our collections and discover something extraordinary.
                    Your next favorite piece is waiting.</p>
                <a href="{{ route('shop') }}"
                    class="inline-block bg-gray-900 border border-gray-900 hover:bg-black hover:border-black text-white transition text-sm font-bold py-3 px-8 uppercase tracking-wider shadow-sm">
                    Return to Shop
                </a>
            </div>
        @endif
    </div>
@endsection