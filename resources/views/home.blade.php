@extends('layouts.store')

@section('content')
    <!-- Hero Slider -->
    <div class="relative w-full overflow-hidden bg-stone-100">
        <div class="flex transition-transform duration-500 ease-in-out" id="sliderContainer">
            @forelse($sliders as $slider)
                <div class="w-full flex-shrink-0 relative">
                    <img src="{{ asset('storage/' . $slider->image) }}"
                        class="w-full h-[60vh] md:h-[70vh] object-cover object-center" alt="{{ $slider->title }}">
                    <div class="absolute inset-0 bg-black bg-opacity-30 flex flex-col justify-center px-8 md:px-24">
                        <div class="max-w-xl">
                            <h2 class="text-4xl md:text-6xl text-white font-serif uppercase tracking-widest leading-tight mb-4">
                                {!! nl2br(e($slider->title)) !!}
                            </h2>
                            @if($slider->subtitle)
                                <p class="text-white text-sm md:text-base font-medium tracking-wide mb-8">
                                    {{ $slider->subtitle }}
                                </p>
                            @endif
                            @if($slider->button_text)
                                <a href="{{ $slider->button_link }}"
                                    class="inline-block bg-[#d4af37] hover:bg-[#c19b28] text-white text-xs md:text-sm tracking-[0.2em] font-bold py-3 px-8 uppercase transition">
                                    {{ $slider->button_text }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <!-- Fallback if no sliders exist (matches reference) -->
                <div class="w-full flex-shrink-0 relative">
                    <div class="w-full h-[60vh] md:h-[70vh] bg-stone-200 flex items-center justify-center">
                        <span class="text-gray-400 font-serif text-2xl">Slider Image Placeholder</span>
                    </div>
                    <div class="absolute inset-0 flex flex-col justify-center px-8 md:px-24">
                        <div class="max-w-xl">
                            <h2
                                class="text-4xl md:text-6xl text-gray-900 font-serif uppercase tracking-widest leading-tight mb-4">
                                ELEGANZ<br>REDEFINED.
                            </h2>
                            <p class="text-gray-700 text-sm md:text-base font-medium tracking-wide mb-8">
                                Discover our curated collections.
                            </p>
                            <a href="{{ route('shop') }}"
                                class="inline-block bg-transparent border border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white text-xs md:text-sm tracking-[0.2em] font-bold py-3 px-8 uppercase transition">
                                SHOP COLLECTION
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        @if(count($sliders) > 1)
            <div class="absolute bottom-6 left-0 w-full flex justify-center space-x-2">
                @foreach($sliders as $idx => $s)
                    <button class="w-10 h-1 rounded-sm bg-white {{ $idx === 0 ? 'opacity-100' : 'opacity-40' }}"></button>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Category Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-10">
            <h3 class="text-2xl font-serif text-gray-900 tracking-wider">Category</h3>
        </div>

        <div class="flex overflow-x-auto no-scrollbar gap-4 md:grid md:grid-cols-3 xl:grid-cols-4 md:gap-6 pb-4">
            @forelse($categories as $category)
                <div class="min-w-[140px] md:min-w-0 flex-shrink-0">
                    <a href="{{ route('shop', ['category' => $category->slug]) }}"
                        class="block group text-center border border-transparent rounded-lg p-2 hover:border-[#d4af37] transition duration-300">
                        <div class="w-full aspect-square mb-3 overflow-hidden rounded overflow-hidden shadow-sm">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full bg-stone-200"></div>
                            @endif
                        </div>
                        <h4 class="text-sm font-semibold text-gray-900 mb-1">{{ $category->name }}</h4>
                        <div class="text-[10px] text-gray-500 uppercase tracking-widest group-hover:text-[#d4af37] transition">
                            Explore</div>
                        <div class="w-6 h-[1px] bg-gray-300 mx-auto mt-2 group-hover:bg-[#d4af37] transition"></div>
                    </a>
                </div>
            @empty
                <p class="text-gray-500 text-center w-full col-span-full font-serif italic">No categories available yet.</p>
            @endforelse
        </div>
    </div>

    <!-- Product Collection Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="text-center mb-10">
            <h3 class="text-2xl font-serif text-gray-900 tracking-wider uppercase">Product Collection</h3>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
            @forelse($products as $product)
                <div class="group flex flex-col">
                    <a href="#"
                        class="relative block overflow-hidden rounded mb-4 shadow-sm bg-white border border-gray-100 p-2">
                        <div class="aspect-[3/4] w-full overflow-hidden rounded">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                    class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-700">
                            @else
                                <div class="w-full h-full bg-stone-100"></div>
                            @endif
                        </div>
                        @if($product->is_featured)
                            <div
                                class="absolute top-4 left-4 text-[9px] font-bold text-white bg-black px-2 py-1 uppercase tracking-wider scale-0 group-hover:scale-100 transition-transform origin-top-left z-10">
                                Featured</div>
                        @endif

                        <div class="pt-4 pb-2 text-center md:text-left">
                            <div class="text-[10px] text-gray-500 uppercase tracking-widest mb-1">
                                {{ $product->category->name ?? 'MUSFIQ' }}</div>
                            <h4 class="text-sm font-semibold text-gray-900 mb-1 line-clamp-2 h-10">{{ $product->name }}</h4>
                            <p class="text-sm text-gray-900 font-bold mb-4">${{ number_format($product->price, 2) }}</p>
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full border border-[#d4af37] bg-white text-[#d4af37] hover:bg-[#d4af37] hover:text-white transition text-xs font-bold py-2.5 uppercase tracking-wider">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </a>
                </div>
            @empty
                <p class="text-gray-500 text-center w-full col-span-full font-serif italic">No products available yet.</p>
            @endforelse
        </div>
    </div>
@endsection