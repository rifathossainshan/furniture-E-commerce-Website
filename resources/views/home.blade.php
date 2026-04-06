@extends('layouts.store')

@section('content')
    <!-- Hero Slider -->
    <div class="relative w-full overflow-hidden bg-stone-100">
        <div class="flex transition-transform duration-500 ease-in-out" id="sliderContainer">
            @forelse($sliders as $slider)
                <div class="w-full flex-shrink-0 relative">
                    <img src="{{ asset($slider->image) }}"
                        class="w-full h-[60vh] md:h-[70vh] object-cover object-center" alt="{{ $slider->title }}">
                    @if($slider->show_text ?? true)
                        <div class="absolute inset-0 bg-black bg-opacity-30 flex flex-col justify-center px-8 md:px-24">
                            <div class="max-w-xl">
                                <h2 class="text-4xl md:text-6xl text-white font-serif uppercase tracking-widest leading-tight mb-4">
                                    {!! $slider->title !!}
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
                    @endif
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
                        class="block group text-center border border-transparent rounded-lg p-4 hover:bg-stone-50 transition duration-300">
                        <div
                            class="w-24 h-24 md:w-32 md:h-32 mx-auto mb-4 overflow-hidden rounded-full shadow-sm border border-gray-100">
                            @if($category->image)
                                <img src="{{ asset($category->image) }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            @else
                                <div class="w-full h-full bg-stone-200"></div>
                            @endif
                        </div>
                        <h4 class="text-sm font-semibold text-gray-900 mb-1 tracking-wide">{{ $category->name }}</h4>
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
                <div class="group relative flex flex-col h-full overflow-hidden rounded shadow-sm bg-white border border-gray-100 p-2">
                    <!-- Wishlist Button -->
                    <form action="{{ route('wishlist.add', $product) }}" method="POST" class="absolute top-4 right-4 z-20">
                        @csrf
                        <button type="submit" class="p-2 bg-white rounded-full shadow hover:bg-gray-50 text-gray-400 hover:text-red-500 transition-colors {{ session('wishlist') && isset(session('wishlist')[$product->id]) ? 'text-red-500' : '' }}" title="Add to Wishlist">
                            <svg class="w-4 h-4" {{ session('wishlist') && isset(session('wishlist')[$product->id]) ? 'fill="currentColor"' : 'fill="none"' }} stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </form>

                    <a href="{{ route('product.show', $product->slug) }}" class="block w-full">
                        <div class="w-full relative overflow-hidden rounded bg-stone-100" style="padding-bottom: 125%;">
                            @if($product->image)
                                <img src="{{ asset($product->image) }}"
                                    class="absolute inset-0 w-full h-full object-cover object-top group-hover:scale-105 transition duration-700">
                            @else
                                <div class="w-full h-full bg-stone-100"></div>
                            @endif
                        </div>
                    </a>

                    @if($product->is_featured)
                        <div class="absolute top-4 left-4 text-[9px] font-bold text-white bg-black px-2 py-1 uppercase tracking-wider scale-0 group-hover:scale-100 transition-transform origin-top-left z-10 pointer-events-none">
                            Featured</div>
                    @endif

                    <div class="pt-4 pb-2 text-center md:text-left flex-1 flex flex-col flex-grow">
                        <a href="{{ route('product.show', $product->slug) }}" class="block">
                            <div class="text-[10px] text-gray-500 uppercase tracking-widest mb-1">
                                {{ $product->category->name ?? 'MUSFIQ' }}
                            </div>
                            <h4 class="text-sm font-semibold text-gray-900 mb-1 line-clamp-2 h-10">{{ $product->name }}</h4>
                            <p class="text-sm text-gray-900 font-bold mb-1">৳{{ number_format($product->price, 2) }}</p>
                            <div class="text-xs text-gray-500 font-semibold mb-4">
                                <span class="text-yellow-500">★</span> {{ number_format($product->reviews_avg_rating ?? 0, 1) }}
                            </div>
                        </a>
                        <div class="mt-auto">
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit" @disabled($product->stock <= 0)
                                    class="w-full border border-[#d4af37] bg-white text-[#d4af37] hover:bg-[#d4af37] hover:text-white transition text-xs font-bold py-2.5 uppercase tracking-wider disabled:opacity-50 disabled:cursor-not-allowed">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center w-full col-span-full font-serif italic">No products available yet.</p>
            @endforelse
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('sliderContainer');
            if (!container) return;
            
            const slides = container.children;
            const totalSlides = slides.length;
            if (totalSlides <= 1) return;

            let currentIndex = 0;
            const dotContainers = document.querySelectorAll('.absolute.bottom-6.left-0 button');
            
            function goToSlide(index) {
                currentIndex = index;
                container.style.transform = `translateX(-${currentIndex * 100}%)`;
                
                dotContainers.forEach((dot, i) => {
                    if (i === currentIndex) {
                        dot.classList.replace('opacity-40', 'opacity-100');
                    } else {
                        dot.classList.replace('opacity-100', 'opacity-40');
                    }
                });
            }
            
            dotContainers.forEach((dot, index) => {
                dot.addEventListener('click', () => goToSlide(index));
            });

            // Auto-slide every 5 seconds
            setInterval(() => {
                let nextIndex = (currentIndex + 1) % totalSlides;
                goToSlide(nextIndex);
            }, 5000);
        });
    </script>
    </div>
@endsection