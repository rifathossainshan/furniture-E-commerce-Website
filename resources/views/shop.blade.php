@extends('layouts.store')

@section('content')
@if(isset($selectedCategory))
<div class="bg-stone-100 py-12 relative overflow-hidden">
    @if($selectedCategory->image)
        <img src="{{ asset($selectedCategory->image) }}" class="absolute inset-0 w-full h-full object-cover opacity-20">
    @endif
    @php
        $titleColor = 'text-gray-900';
        $descColor = 'text-gray-600';
        if($selectedCategory->text_color === 'white') {
            $titleColor = 'text-white';
            $descColor = 'text-gray-100';
        } elseif($selectedCategory->text_color === 'red') {
            $titleColor = 'text-red-600';
            $descColor = 'text-red-500';
        } elseif($selectedCategory->text_color === 'golden') {
            $titleColor = 'text-yellow-500';
            $descColor = 'text-yellow-400';
        } elseif($selectedCategory->text_color === 'blue') {
            $titleColor = 'text-blue-600';
            $descColor = 'text-blue-500';
        }
    @endphp
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h1 class="text-4xl font-serif tracking-widest uppercase mb-4 {{ $titleColor }}">{{ $selectedCategory->name }}</h1>
        @if($selectedCategory->description)
            <p class="max-w-2xl mx-auto {{ $descColor }}">{{ $selectedCategory->description }}</p>
        @endif
    </div>
</div>
@else
<div class="bg-stone-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-serif text-gray-900 tracking-widest uppercase mb-4">Shop Collection</h1>
        <p class="text-gray-600 max-w-2xl mx-auto">Explore our full range of premium products. Find exactly what you are looking for.</p>
    </div>
</div>
@endif

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex flex-col md:flex-row gap-8">
    
    <!-- Sidebar / Filters -->
    <div class="w-full md:w-64 flex-shrink-0">
        <form action="{{ route('shop') }}" method="GET" class="mb-8">
            <div class="relative">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products..." class="w-full pl-10 pr-4 py-2 border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900 text-sm">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
        </form>

        <div class="mb-8">
            <h3 class="font-bold text-gray-900 uppercase tracking-wider text-sm mb-4 border-b border-gray-200 pb-2">Categories</h3>
            <ul class="space-y-3">
                <li>
                    <a href="{{ route('shop', array_merge(request()->query(), ['category' => null])) }}" class="text-sm transition {{ !request('category') ? 'text-black font-semibold' : 'text-gray-600 hover:text-black' }}">All Products</a>
                </li>
                @foreach($categories as $category)
                <li>
                    <a href="{{ route('shop', array_merge(request()->query(), ['category' => $category->slug])) }}" class="text-sm transition {{ request('category') == $category->slug ? 'text-black font-semibold' : 'text-gray-600 hover:text-black' }}">{{ $category->name }}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="flex-1">
        <div class="flex justify-between items-center mb-6">
            <p class="text-sm text-gray-500">Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results</p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8">
            @forelse($products as $product)
            <div class="group relative flex flex-col h-full overflow-hidden rounded mb-4 shadow-sm bg-white border border-gray-100 p-2">
                
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
                            <img src="{{ asset($product->image) }}" class="absolute inset-0 w-full h-full object-cover object-top group-hover:scale-105 transition duration-700">
                        @else
                            <div class="w-full h-full bg-stone-100"></div>
                        @endif
                        @if($product->stock <= 0)
                            <div class="absolute inset-0 bg-white/60 flex items-center justify-center">
                                <span class="bg-white text-gray-900 font-bold px-3 py-1 text-xs tracking-wider uppercase border border-gray-200 shadow-sm">Out of Stock</span>
                            </div>
                        @endif
                    </div>
                </a>

                @if($product->is_featured)
                    <div class="absolute top-4 left-4 text-[9px] font-bold text-white bg-black px-2 py-1 uppercase tracking-wider scale-0 group-hover:scale-100 transition-transform origin-top-left z-10 pointer-events-none">Featured</div>
                @endif
                
                <div class="pt-4 pb-2 text-center flex-1 flex flex-col flex-grow">
                    <a href="{{ route('product.show', $product->slug) }}" class="block">
                        <div class="text-[10px] text-gray-500 uppercase tracking-widest mb-1">{{ $product->category->name ?? 'MUSFIQ' }}</div>
                        <h4 class="text-sm font-semibold text-gray-900 mb-1 line-clamp-2 uppercase">{{ $product->name }}</h4>
                        <p class="text-[11px] text-gray-500 mb-2 line-clamp-2">{{ Str::limit(strip_tags($product->description), 60) }}</p>
                        <p class="text-base text-gray-900 font-bold mb-2">৳{{ number_format($product->price, 2) }}</p>
                        <div class="text-xs text-gray-500 font-semibold mb-4 flex justify-center items-center gap-1">
                            <span class="text-gray-500">★</span> {{ number_format($product->reviews_avg_rating ?? 0, 1) }}
                        </div>
                    </a>
                    <div class="mt-auto">
                        <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                            <button type="submit" @disabled($product->stock <= 0) class="w-full btn-primary text-xs tracking-wider disabled:opacity-50 disabled:cursor-not-allowed">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-center">
                <p class="text-gray-500 text-lg font-serif italic mb-4">No products match your criteria.</p>
                <a href="{{ route('shop') }}" class="text-indigo-600 hover:text-indigo-900">Clear all filters</a>
            </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
