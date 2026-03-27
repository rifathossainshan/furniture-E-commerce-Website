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
            <div class="w-full md:w-1/2" x-data="{ currentSlide: 0, images: {{ json_encode($allImages, JSON_UNESCAPED_SLASHES) }} }">
                <div class="aspect-[3/4] w-full overflow-hidden rounded bg-stone-100 mb-4 shadow-sm border border-gray-100 relative group">
                    <template x-if="images.length > 0">
                        <img :src="images[currentSlide]" class="w-full h-full object-cover object-top transition duration-500">
                    </template>
                    <template x-if="images.length === 0">
                        <div class="w-full h-full flex flex-col justify-center items-center text-gray-400">
                            <svg class="h-16 w-16 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span>No Image Available</span>
                        </div>
                    </template>
                    
                    <!-- Slider Arrows (only show if more than 1 image) -->
                    <template x-if="images.length > 1">
                        <div>
                            <!-- Prev Arrow -->
                            <button @click="currentSlide = currentSlide > 0 ? currentSlide - 1 : images.length - 1" class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 p-2 rounded-full shadow-md opacity-0 group-hover:opacity-100 transition focus:outline-none">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <!-- Next Arrow -->
                            <button @click="currentSlide = currentSlide < images.length - 1 ? currentSlide + 1 : 0" class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 p-2 rounded-full shadow-md opacity-0 group-hover:opacity-100 transition focus:outline-none">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>
                
                <!-- Thumbnails Gallery -->
                <template x-if="images.length > 1">
                    <div class="grid grid-cols-4 gap-2 md:gap-4 mt-4">
                        <template x-for="(img, index) in images" :key="index">
                            <button @click="currentSlide = index" :class="{'ring-2 ring-gray-900 border-transparent': currentSlide === index, 'border-gray-200': currentSlide !== index}" class="aspect-[3/4] overflow-hidden rounded border transition focus:outline-none">
                                <img :src="img" class="w-full h-full object-cover object-top hover:opacity-80 transition">
                            </button>
                        </template>
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

                <div class="mb-8 border-t border-gray-200 pt-6">
                    <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-2">Availability</p>
                    @if($product->stock > 0)
                        <p class="text-green-600 font-medium text-sm flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            In Stock ({{ $product->stock }} items)
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

                <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-auto">
                    @csrf
                    <button type="submit" @disabled($product->stock <= 0)
                        class="w-full border border-[#d4af37] bg-[#d4af37] text-white hover:bg-[#c19b28] hover:border-[#c19b28] transition py-4 tracking-[0.2em] text-sm font-bold uppercase shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                        {{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                    </button>
                </form>

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
                        <div class="group flex flex-col">
                            <a href="{{ route('product.show', $related->slug) }}"
                                class="relative block overflow-hidden rounded mb-4 shadow-sm bg-white border border-gray-100 p-2">
                                <div class="aspect-[3/4] w-full overflow-hidden rounded relative">
                                    @if($related->image)
                                        <img src="{{ asset('storage/' . $related->image) }}"
                                            class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-700">
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

                                <div class="pt-4 pb-2 text-center md:text-left">
                                    <div class="text-[10px] text-gray-500 uppercase tracking-widest mb-1">
                                        {{ $related->category->name ?? 'MUSFIQ' }}</div>
                                    <h4 class="text-sm font-semibold text-gray-900 mb-1 line-clamp-2 h-10">{{ $related->name }}</h4>
                                    <p class="text-sm text-gray-900 font-bold mb-4">${{ number_format($related->price, 2) }}</p>
                                    <form action="{{ route('cart.add', $related) }}" method="POST">
                                        @csrf
                                        <button type="submit" @disabled($related->stock <= 0)
                                            class="w-full border border-[#d4af37] bg-white text-[#d4af37] hover:bg-[#d4af37] hover:text-white transition text-xs font-bold py-2.5 uppercase tracking-wider disabled:opacity-50 disabled:cursor-not-allowed">
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection