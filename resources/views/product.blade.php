@extends('layouts.store')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative mb-8">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Product Top Section -->
        <div class="flex flex-col md:flex-row gap-12">

            <!-- Left: Image Gallery -->
            @php
                $allImages = [];
                if ($product->image) {
                    $allImages[] = asset('storage/' . $product->image);
                }
                if (is_array($product->images)) {
                    foreach($product->images as $img) {
                        $allImages[] = asset('storage/' . $img);
                    }
                }
            @endphp
            <style>
                .no-scrollbar::-webkit-scrollbar {
                    display: none;
                }
                .no-scrollbar {
                    -ms-overflow-style: none;
                    scrollbar-width: none;
                }
            </style>
            <div class="w-full md:w-1/2" x-data="{ currentSlide: 0, images: {{ json_encode($allImages, JSON_UNESCAPED_SLASHES) }} }">
                <!-- Main Image -->
                <div class="w-full overflow-hidden bg-stone-100 mb-4 shadow-sm border border-gray-100 relative group">
                    <template x-if="images.length > 0">
                        <img :src="images[currentSlide]" class="w-full aspect-square object-cover object-center transition duration-500">
                    </template>
                    <template x-if="images.length === 0">
                        <div class="w-full aspect-square flex flex-col justify-center items-center text-gray-400">
                            <svg class="h-16 w-16 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span>No Image Available</span>
                        </div>
                    </template>
                </div>
                
                <!-- Thumbnails Gallery & Arrows -->
                <template x-if="images.length > 1">
                    <div class="flex items-center justify-center gap-2 mt-4">
                        <!-- Prev Arrow -->
                        <button @click="currentSlide = currentSlide > 0 ? currentSlide - 1 : images.length - 1" class="p-2 text-gray-400 hover:text-gray-900 focus:outline-none flex-shrink-0 transition">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        
                        <!-- Thumbnails -->
                        <div class="flex overflow-x-auto snap-x gap-3 py-1 no-scrollbar justify-center items-center px-2">
                            <template x-for="(img, index) in images" :key="index">
                                <button @click="currentSlide = index" 
                                    :class="{'border-black': currentSlide === index, 'border-transparent': currentSlide !== index}" 
                                    class="flex-shrink-0 w-20 h-20 md:w-24 md:h-24 overflow-hidden border-2 transition focus:outline-none snap-start bg-white">
                                    <img :src="img" class="w-full h-full object-cover hover:opacity-80 transition p-0.5">
                                </button>
                            </template>
                        </div>

                        <!-- Next Arrow -->
                        <button @click="currentSlide = currentSlide < images.length - 1 ? currentSlide + 1 : 0" class="p-2 text-gray-400 hover:text-gray-900 focus:outline-none flex-shrink-0 transition">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </template>
            </div>

            <!-- Right: Product Info -->
            <div class="w-full md:w-1/2 flex flex-col pt-4 md:pt-10">
                <div class="text-[10px] text-gray-500 uppercase tracking-widest mb-2">
                    {{ $product->category->name ?? 'MUSFIQ' }}</div>
                <h1 class="text-3xl md:text-4xl font-serif text-gray-900 leading-tight mb-4">{{ $product->name }}</h1>

                <p class="text-2xl text-gray-900 font-bold mb-6">${{ number_format($product->price, 2) }}</p>

                <div class="prose prose-sm text-gray-600 mb-8">
                    <p>{{ $product->description }}</p>
                </div>

                @if($product->attributes && $product->attributes->count() > 0)
                <div class="mb-8 border-t border-gray-200 pt-6">
                    <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-4">Specifications</p>
                    <div class="grid grid-cols-2 gap-y-4 gap-x-6">
                        @foreach($product->attributes as $attribute)
                        <div class="flex flex-col">
                            <span class="text-[10px] text-gray-500 uppercase tracking-widest font-semibold">{{ $attribute->name }}</span>
                            <span class="text-sm font-medium text-gray-900">{{ $attribute->value }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="mb-8 border-t border-gray-200 pt-6">
                    <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-2">Availability</p>
                    @if($product->stock > 0)
                        <p class="text-green-600 font-medium text-sm flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            In Stock
                        </p>
                    @else
                        <p class="text-red-600 font-medium text-sm flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                                </path>
                            </svg>
                            Out of Stock
                        </p>
                    @endif
                </div>

                <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-auto flex flex-col md:flex-row gap-4">
                    @csrf
                    <button type="submit" @disabled($product->stock <= 0)
                        class="flex-1 border border-[#d4af37] bg-white text-[#d4af37] hover:bg-stone-50 transition py-4 tracking-[0.2em] text-sm font-bold uppercase shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                        {{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                    </button>
                    @if($product->stock > 0)
                        <button type="submit" name="buy_now" value="1"
                            class="flex-1 border border-[#d4af37] bg-[#d4af37] text-white hover:bg-[#c19b28] hover:border-[#c19b28] transition py-4 tracking-[0.2em] text-sm font-bold uppercase shadow-sm">
                            Buy Now
                        </button>
                    @endif
                </form>

                <div class="mt-4">
                    <form action="{{ route('wishlist.add', $product) }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center text-sm font-semibold tracking-wide transition {{ session('wishlist') && isset(session('wishlist')[$product->id]) ? 'text-red-500' : 'text-gray-500 hover:text-red-500' }}">
                            <svg class="w-5 h-5 mr-2" {{ session('wishlist') && isset(session('wishlist')[$product->id]) ? 'fill="currentColor"' : 'fill="none"' }} stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            {{ session('wishlist') && isset(session('wishlist')[$product->id]) ? 'Saved to Wishlist' : 'Add to Wishlist' }}
                        </button>
                    </form>
                </div>

                <!-- Additional Guarantees -->
                <div class="mt-8 grid grid-cols-2 gap-4 border-t border-gray-200 pt-6">
                    <div class="flex items-start text-gray-500 text-xs">
                        <svg class="h-5 w-5 mr-3 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4">
                            </path>
                        </svg>
                        <span>Free Global Shipping<br />on orders over $500</span>
                    </div>
                    <div class="flex items-start text-gray-500 text-xs">
                        <svg class="h-5 w-5 mr-3 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>30-Day Free Returns<br />No questions asked</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if(count($relatedProducts) > 0)
            <div class="mt-24">
                <div class="text-center mb-10">
                    <h3 class="text-2xl font-serif text-gray-900 tracking-wider">You May Also Like</h3>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
                    @foreach($relatedProducts as $related)
                        <div class="group relative flex flex-col overflow-hidden rounded mb-4 shadow-sm bg-white border border-gray-100 p-2">
                            <!-- Wishlist Button -->
                            <form action="{{ route('wishlist.add', $related) }}" method="POST" class="absolute top-4 right-4 z-20">
                                @csrf
                                <button type="submit" class="p-2 bg-white rounded-full shadow hover:bg-gray-50 text-gray-400 hover:text-red-500 transition-colors {{ session('wishlist') && isset(session('wishlist')[$related->id]) ? 'text-red-500' : '' }}" title="Add to Wishlist">
                                    <svg class="w-4 h-4" {{ session('wishlist') && isset(session('wishlist')[$related->id]) ? 'fill="currentColor"' : 'fill="none"' }} stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </form>

                            <a href="{{ route('product.show', $related->slug) }}" class="block w-full">
                                <div class="aspect-square w-full overflow-hidden rounded relative">
                                    @if($related->image)
                                        <img src="{{ asset('storage/' . $related->image) }}"
                                            class="w-full h-full object-cover object-center group-hover:scale-105 transition duration-700">
                                    @else
                                        <div class="w-full h-full bg-stone-100"></div>
                                    @endif
                                    @if($related->stock <= 0)
                                        <div class="absolute inset-0 bg-white/60 flex items-center justify-center">
                                            <span
                                                class="bg-white text-gray-900 font-bold px-3 py-1 text-xs tracking-wider uppercase border border-gray-200 shadow-sm">Out
                                                of Stock</span>
                                        </div>
                                    @endif
                                </div>
                            </a>

                            <div class="pt-4 pb-2 text-center md:text-left flex-1 flex flex-col flex-grow">
                                <a href="{{ route('product.show', $related->slug) }}" class="block">
                                    <div class="text-[10px] text-gray-500 uppercase tracking-widest mb-1">
                                        {{ $related->category->name ?? 'MUSFIQ' }}</div>
                                    <h4 class="text-sm font-semibold text-gray-900 mb-1 line-clamp-2 h-10">{{ $related->name }}</h4>
                                    <p class="text-sm text-gray-900 font-bold mb-4">${{ number_format($related->price, 2) }}</p>
                                </a>
                                <div class="mt-auto">
                                    <form action="{{ route('cart.add', $related) }}" method="POST">
                                        @csrf
                                        <button type="submit" @disabled($related->stock <= 0)
                                            class="w-full border border-[#d4af37] bg-white text-[#d4af37] hover:bg-[#d4af37] hover:text-white transition text-xs font-bold py-2.5 uppercase tracking-wider disabled:opacity-50 disabled:cursor-not-allowed">
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection