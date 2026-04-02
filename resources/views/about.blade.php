@extends('layouts.store')

@section('content')
<!-- Hero Section -->
<div class="relative bg-stone-900 overflow-hidden text-center md:text-left">
    <!-- Background Texture/Overlay -->
    <div class="absolute inset-0 z-0 opacity-40">
        <img src="https://images.unsplash.com/photo-1445205170230-053b83016050?q=80&w=2671&auto=format&fit=crop" class="w-full h-full object-cover object-center filter grayscale" alt="Fashion background">
    </div>
    <div class="absolute inset-0 z-10 bg-gradient-to-t md:bg-gradient-to-r from-stone-950 via-stone-900/80 to-transparent"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 py-24 md:py-36 flex flex-col items-center md:items-start group">
        <span class="text-[#d4af37] font-semibold tracking-[0.2em] uppercase text-xs sm:text-sm mb-4 block transform transition-transform duration-700 hover:translate-x-2">Our Story</span>
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-serif text-white tracking-wide mb-6 leading-tight">
            Redefining <br> <span class="italic text-stone-300">Modern Elegance</span>
        </h1>
    </div>
</div>

<!-- Main Content Area -->
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-24 items-center">
            
            <!-- Left: Text Content -->
            <div class="lg:col-span-6 lg:col-start-1 order-2 lg:order-1">
                <div class="mb-8">
                    <h2 class="text-3xl md:text-4xl font-serif text-gray-900 mb-6">About Musfiq</h2>
                    <div class="w-16 h-1 bg-[#d4af37] mb-8"></div>
                </div>
                
                <!-- Admin Controlled Content -->
                <div class="prose prose-lg text-gray-600 leading-relaxed font-light mb-10 w-full text-justify sm:text-left max-w-none">
                    @php
                        $aboutUsRaw = \App\Models\Setting::where('key', 'about_us')->value('value') ?? 'Welcome to Musfiq. We redefine elegance and craft quality products that speak for themselves.';
                    @endphp
                    
                    {!! nl2br(e($aboutUsRaw)) !!}
                </div>

                <div class="flex items-center space-x-6 border-t border-gray-100 pt-8 mt-12">
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-[#d4af37] font-bold mb-1">Established</p>
                        <p class="font-serif text-2xl text-gray-900">2026</p>
                    </div>
                    <div class="w-px h-12 bg-gray-200"></div>
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-[#d4af37] font-bold mb-1">Collections</p>
                        <p class="font-serif text-2xl text-gray-900">Premium</p>
                    </div>
                </div>
            </div>
            
            <!-- Right: Feature Image -->
            <div class="lg:col-span-5 lg:col-start-8 order-1 lg:order-2 group">
                <div class="relative overflow-hidden w-full bg-stone-100 aspect-[3/4] sm:aspect-[4/5] object-cover rounded-sm shadow-xl">
                    <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=2670&auto=format&fit=crop" 
                         alt="About Us Aesthetic" 
                         class="absolute inset-0 w-full h-full object-cover object-center transition-transform duration-1000 group-hover:scale-105">
                </div>
                <!-- Decorative Element -->
                <div class="hidden lg:block absolute -z-10 -bottom-8 -right-8 w-2/3 h-2/3 border border-[#d4af37] transition-all duration-700 group-hover:translate-x-2 group-hover:translate-y-2"></div>
            </div>
            
        </div>
    </div>
</div>

<!-- Core Values Section -->
<div class="bg-stone-50 border-t border-stone-200 pt-20 pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h3 class="text-2xl font-serif text-gray-900 tracking-wide mb-16">The Core of Our Craft</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 max-w-5xl mx-auto">
            <!-- Value 1 -->
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 flex items-center justify-center bg-white rounded-full shadow-sm mb-6 border border-gray-100 text-[#d4af37]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                </div>
                <h4 class="text-sm font-bold uppercase tracking-widest text-gray-900 mb-3">Unmatched Quality</h4>
                <p class="text-xs text-gray-500 leading-loose max-w-xs px-4">Every piece is crafted meticulously with premium materials to ensure durability and lasting beauty.</p>
            </div>
            
            <!-- Value 2 -->
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 flex items-center justify-center bg-white rounded-full shadow-sm mb-6 border border-gray-100 text-[#d4af37]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h4 class="text-sm font-bold uppercase tracking-widest text-gray-900 mb-3">Global Appeal</h4>
                <p class="text-xs text-gray-500 leading-loose max-w-xs px-4">Our aesthetic transcends borders, bringing a universal sense of sophisticated style directly to you.</p>
            </div>
            
            <!-- Value 3 -->
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 flex items-center justify-center bg-white rounded-full shadow-sm mb-6 border border-gray-100 text-[#d4af37]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                    </svg>
                </div>
                <h4 class="text-sm font-bold uppercase tracking-widest text-gray-900 mb-3">Exceptional Service</h4>
                <p class="text-xs text-gray-500 leading-loose max-w-xs px-4">We are dedicated to providing a shopping experience as refined and flawless as the products we offer.</p>
            </div>
        </div>
    </div>
</div>
@endsection
