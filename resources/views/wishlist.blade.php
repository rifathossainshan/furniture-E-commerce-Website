@extends('layouts.store')

@section('content')
    <div class="bg-stone-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-serif text-gray-900 tracking-widest uppercase mb-4">My Wishlist</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-white">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(count($wishlist) > 0)
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
                @foreach($wishlist as $id => $details)
                <div class="group relative flex flex-col overflow-hidden rounded mb-4 shadow-sm bg-white border border-gray-100 p-2">
                    
                    <!-- Remove from Wishlist Button -->
                    <form action="{{ route('wishlist.remove') }}" method="POST" class="absolute top-4 right-4 z-20">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" value="{{ $id }}">
                        <button type="submit" class="p-2 bg-white rounded-full shadow hover:bg-gray-50 text-red-500 hover:text-red-700 transition" title="Remove from Wishlist">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>

                    <a href="{{ route('product.show', $details['slug'] ?? '#') }}" class="block w-full">
                        <div class="w-full relative overflow-hidden rounded bg-stone-100" style="padding-bottom: 125%;">
                            @if($details['image'])
                                <img src="{{ asset('storage/' . $details['image']) }}" class="absolute inset-0 w-full h-full object-cover object-center group-hover:scale-105 transition duration-700">
                            @else
                                <div class="w-full h-full bg-stone-100"></div>
                            @endif
                        </div>
                    </a>

                    <div class="pt-4 pb-2 text-center md:text-left flex-1 flex flex-col flex-grow">
                        <a href="{{ route('product.show', $details['slug'] ?? '#') }}" class="block">
                            <h4 class="text-sm font-semibold text-gray-900 mb-1 line-clamp-2 h-10">{{ $details['name'] }}</h4>
                            <p class="text-sm text-gray-900 font-bold mb-4">৳{{ number_format($details['price'], 2) }}</p>
                        </a>
                        <div class="mt-auto">
                            <form action="{{ route('cart.add', ['product' => $details['product_id']]) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full border border-[#d4af37] bg-white text-[#d4af37] hover:bg-[#d4af37] hover:text-white transition text-xs font-bold py-2.5 uppercase tracking-wider">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-8 text-center">
                <a href="{{ route('shop') }}" class="inline-block text-gray-500 hover:text-gray-900 transition text-sm uppercase tracking-wider font-semibold">
                    Continue Shopping
                </a>
            </div>
        @else
            <div class="text-center py-20 pb-40">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <h2 class="text-2xl font-serif text-gray-900 mb-4">Your wishlist is empty</h2>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">Save your favorite items here to view or buy them later.</p>
                <a href="{{ route('shop') }}"
                    class="inline-block bg-gray-900 border border-gray-900 hover:bg-black hover:border-black text-white transition text-sm font-bold py-3 px-8 uppercase tracking-wider shadow-sm">
                    Discover Products
                </a>
            </div>
        @endif
    </div>
@endsection
