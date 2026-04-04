@extends('layouts.store')

@section('content')
<div class="bg-white py-12" x-data="{ 
    deliveryArea: 'inside_dhaka', 
    subtotal: {{ $subtotal }}, 
    discount: {{ $discount }}, 
    get deliveryCharge() { return this.deliveryArea === 'inside_dhaka' ? 70 : 130; }, 
    get total() { return Math.max(0, this.subtotal - this.discount) + this.deliveryCharge; } 
}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-900 uppercase tracking-widest">CHECKOUT</h1>
        </div>

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

        <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form" class="flex flex-col lg:flex-row gap-12 lg:gap-20" onsubmit="fbq('track', 'Lead');">
            @csrf
            
            <!-- Left Column: Billing Details -->
            <div class="lg:w-1/2">
                <h3 class="text-xl font-bold text-gray-900 mb-6 uppercase tracking-wider border-b border-gray-100 pb-2">
                    BILLING DETAILS</h3>

                <div class="space-y-6">
                    <div>
                        <label class="block text-gray-900 text-sm font-bold uppercase mb-2">FULL NAME</label>
                        <input type="text" name="name" value="{{ auth()->check() ? auth()->user()->name : '' }}" required
                            class="w-full border-gray-200 focus:border-gray-900 focus:ring-0 text-gray-900 bg-white shadow-sm p-3">
                    </div>

                    <div>
                        <label class="block text-gray-900 text-sm font-bold uppercase mb-2">PHONE</label>
                        <input type="text" name="phone" required
                            class="w-full border-gray-200 focus:border-gray-900 focus:ring-0 text-gray-900 bg-white shadow-sm p-3">
                    </div>

                    <div>
                        <label class="block text-gray-900 text-sm font-bold uppercase mb-2">DELIVERY ADDRESS</label>
                        <textarea name="address" rows="4" required
                            class="w-full border-gray-200 focus:border-gray-900 focus:ring-0 text-gray-900 bg-white shadow-sm p-3 resize-none"></textarea>
                    </div>

                    <div class="pt-4">
                        <label class="block text-gray-900 text-sm font-bold uppercase mb-4">DELIVERY AREA</label>
                        <div class="space-y-3">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" x-model="deliveryArea" name="delivery_area" value="inside_dhaka" class="w-5 h-5 border-gray-300 text-gray-900 focus:ring-gray-900">
                                <span class="ml-3 text-gray-900 text-base">Inside Dhaka (৳70)</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" x-model="deliveryArea" name="delivery_area" value="outside_dhaka" class="w-5 h-5 border-gray-300 text-gray-900 focus:ring-gray-900">
                                <span class="ml-3 text-gray-900 text-base">Outside Dhaka (৳130)</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Summary & Place Order -->
            <div class="lg:w-1/2">
                
                <!-- Cash on Delivery Box -->
                <div class="border-2 border-gray-900 p-4 mb-6">
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="payment_method" value="cod" checked class="w-5 h-5 border-gray-300 text-gray-900 focus:ring-gray-900">
                        <span class="ml-3 text-gray-900 font-bold tracking-wider uppercase">CASH ON DELIVERY</span>
                    </label>
                </div>

                <!-- Place Order Button -->
                <button type="submit" class="w-full bg-black text-white font-bold py-5 px-4 tracking-widest uppercase mb-10 hover:bg-gray-800 transition">
                    PLACE ORDER
                </button>

                <!-- Order Summary Box -->
                <div class="bg-stone-50 p-6 md:p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 uppercase tracking-wider">
                        YOUR ORDER</h3>

                    <div class="space-y-4 mb-8">
                        @foreach($cart as $details)
                            <div class="flex justify-between items-start">
                                <div class="pr-4">
                                    <h4 class="font-bold text-gray-900 uppercase text-sm leading-snug">{{ $details['name'] }}</h4>
                                    <p class="text-gray-500 text-xs mt-1">Qty: {{ $details['quantity'] }}</p>
                                </div>
                                <span class="font-bold text-gray-900 whitespace-nowrap">৳{{ number_format($details['price'] * $details['quantity']) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-4 text-sm font-bold text-gray-600 border-t border-gray-200 pt-6">
                        <div class="flex justify-between">
                            <span class="uppercase">SUBTOTAL</span>
                            <span class="text-gray-900">৳{{ number_format($subtotal) }}</span>
                        </div>
                        
                        @if($discount > 0)
                            <div class="flex justify-between text-red-600">
                                <span class="uppercase">DISCOUNT</span>
                                <span>-৳{{ number_format($discount) }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between">
                            <span class="uppercase">DELIVERY CHARGE</span>
                            <span class="text-gray-900" x-text="'৳' + deliveryCharge"></span>
                        </div>
                    </div>

                    <div class="flex justify-between mt-6 pt-6 border-t-2 border-black text-xl font-bold text-gray-900">
                        <span class="uppercase">TOTAL</span>
                        <span x-text="'৳' + total"></span>
                    </div>

                    <p class="text-center text-xs text-gray-400 mt-8">
                        By placing your order, you agree to our Terms of Service and Privacy Policy.
                    </p>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection