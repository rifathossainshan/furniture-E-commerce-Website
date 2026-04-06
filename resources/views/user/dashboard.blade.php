@extends('layouts.store')

@section('content')
    <div class="bg-stone-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-serif text-gray-900 tracking-widest uppercase mb-4">My Account</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative mb-8">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex flex-col md:flex-row gap-8">

            <!-- Sidebar Navigation -->
            <div class="w-full md:w-64 flex-shrink-0">
                <div class="bg-white border border-gray-100 shadow-sm rounded p-6">
                    <div class="mb-6 border-b border-gray-100 pb-4">
                        <p class="font-bold text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                    </div>
                    <ul class="space-y-4 text-sm font-medium">
                        <li>
                            <a href="{{ route('dashboard') }}" class="flex items-center text-black">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Order History
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center text-gray-500 hover:text-black transition">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profile details
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center text-gray-500 hover:text-red-600 transition w-full text-left">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    Log out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content (Orders) -->
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 font-serif">Order History</h2>

                @forelse($orders as $order)
                    <div class="bg-white border border-gray-200 rounded shadow-sm mb-6 overflow-hidden">
                        <div
                            class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex flex-wrap justify-between items-center gap-4">
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-1">Order Placed</p>
                                <p class="text-sm font-medium text-gray-900">{{ $order->created_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-1">Total</p>
                                <p class="text-sm font-medium text-gray-900">৳{{ number_format($order->final_amount, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-1">Order Number</p>
                                <p class="text-sm font-medium text-gray-900">#{{ $order->order_number }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $order->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $order->status === 'shipped' ? 'bg-purple-100 text-purple-800' : '' }}
                                        {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ $order->status }}
                                </span>
                                <a href="{{ route('order.invoice', $order) }}" class="text-gray-500 hover:text-black transition flex items-center gap-1 text-sm font-semibold uppercase tracking-wider">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Invoice
                                </a>
                            </div>
                        </div>
                        <div class="p-6">
                            @foreach($order->items as $item)
                                <div class="flex items-center gap-4 {{ !$loop->last ? 'mb-4 pb-4 border-b border-gray-100' : '' }}">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset($item->product->image) }}"
                                            class="w-16 h-20 object-cover rounded border border-gray-100">
                                    @else
                                        <div class="w-16 h-20 bg-stone-100 rounded border border-gray-100"></div>
                                    @endif
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-900 text-sm">
                                            {{ $item->product->name ?? 'Product Unavailable' }}</h4>
                                        <p class="text-sm text-gray-500 mt-1">Qty: {{ $item->quantity }} x
                                            ৳{{ number_format($item->price, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-white border border-gray-100 rounded shadow-sm">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <p class="text-gray-500 font-medium mb-4">You haven't placed any orders yet.</p>
                        <a href="{{ route('shop') }}"
                            class="inline-block bg-[#d4af37] border border-[#d4af37] hover:bg-[#c19b28] hover:border-[#c19b28] text-white transition text-xs font-bold py-2.5 px-6 uppercase tracking-wider">
                            Start Shopping
                        </a>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
@endsection