@php
    $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $settings['site_name'] ?? config('app.name', 'Musfiq') }}</title>
    @if(isset($settings['site_logo']))
        <link rel="icon" href="{{ asset('storage/' . $settings['site_logo']) }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700|playfair-display:400,600,700&display=swap"
        rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .font-sans {
            font-family: 'Inter', sans-serif;
        }

        /* Hide scrollbar for horizontal scroll areas */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="font-sans antialiased bg-stone-50 text-gray-900 pb-20 md:pb-0">

    <!-- Top Notice Bar -->
    @if(($settings['notice_active'] ?? '1') == '1')
        <div class="bg-black text-white text-[10px] sm:text-xs tracking-widest text-center py-2 px-4 uppercase font-medium">
            {{ $settings['notice_text'] ?? 'FREE GLOBAL SHIPPING ON ORDERS OVER $500. SHOP NOW' }}
        </div>
    @endif

    <!-- Navbar -->
    <header class="bg-white sticky top-0 z-50 shadow-sm" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Hamburger (Mobile) -->
                <div class="flex items-center md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="text-gray-600 hover:text-gray-900 focus:outline-none focus:text-gray-900">
                        <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileMenuOpen" style="display: none;" class="h-6 w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center justify-center flex-1 md:flex-none md:justify-start">
                    <a href="{{ url('/') }}" class="text-2xl font-serif font-semibold tracking-wider text-gray-900">
                        @if(isset($settings['site_logo']))
                            <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo" class="h-8 w-auto">
                        @else
                            {{ $settings['site_name'] ?? 'Musfiq' }}
                        @endif
                    </a>
                </div>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex space-x-8 ml-10">
                    <a href="{{ url('/') }}"
                        class="text-gray-700 hover:text-black font-medium text-sm transition tracking-wider uppercase">Home</a>
                    <a href="{{ route('shop') }}"
                        class="text-gray-700 hover:text-black font-medium text-sm transition tracking-wider uppercase">Shop</a>
                    <a href="{{ url('/about') }}"
                        class="text-gray-700 hover:text-black font-medium text-sm transition tracking-wider uppercase">About</a>
                </nav>

                <!-- Icons -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('shop') }}" class="text-gray-600 hover:text-gray-900 transition">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </a>
                    <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-gray-900 transition relative">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span
                                class="absolute -top-1.5 -right-2 bg-[#d4af37] text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full leading-none">{{ count(session('cart')) }}</span>
                        @endif
                    </a>
                    <a href="{{ route('profile.edit') }}"
                        class="text-gray-600 hover:text-gray-900 transition hidden md:block">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenuOpen" style="display: none;"
            class="md:hidden bg-white border-t border-gray-100 shadow-lg absolute w-full">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ url('/') }}"
                    class="block px-3 py-3 text-sm font-medium text-gray-900 border-b border-gray-50 uppercase tracking-widest">Home</a>
                <a href="{{ route('shop') }}"
                    class="block px-3 py-3 text-sm font-medium text-gray-900 border-b border-gray-50 uppercase tracking-widest">Shop</a>
                <a href="{{ url('/about') }}"
                    class="block px-3 py-3 text-sm font-medium text-gray-900 uppercase tracking-widest">About</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-200 mt-12 pb-24 md:pb-12 pt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="space-y-4">
                <a href="{{ url('/') }}" class="text-2xl font-serif font-semibold tracking-wider text-gray-900">
                    {{ $settings['site_name'] ?? 'Musfiq' }}
                </a>
                <p class="text-sm text-gray-500 leading-relaxed">
                    {{ $settings['about_us'] ?? 'Elevating elegance and style.' }}
                </p>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 mb-4 tracking-wider uppercase text-sm">Shop</h4>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="{{ route('shop') }}" class="hover:text-black transition">All Products</a></li>
                    <li><a href="#" class="hover:text-black transition">New Arrivals</a></li>
                    <li><a href="#" class="hover:text-black transition">Collections</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 mb-4 tracking-wider uppercase text-sm">Support</h4>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="#" class="hover:text-black transition">Contact Us</a></li>
                    <li><a href="#" class="hover:text-black transition">Return Policy</a></li>
                    <li><a href="#" class="hover:text-black transition">Privacy Policy</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 mb-4 tracking-wider uppercase text-sm">Contact</h4>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li>{{ $settings['contact_email'] ?? 'support@musfiq.com' }}</li>
                    <li>{{ $settings['contact_phone'] ?? '+1 234 567 890' }}</li>
                </ul>
            </div>
        </div>
        <div class="text-center text-xs text-gray-400 mt-12 border-t border-gray-200 pt-8 max-w-7xl mx-auto px-4">
            &copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'Musfiq' }}. All rights reserved.
        </div>
    </footer>

    <!-- Mobile Bottom Navigation -->
    <div
        class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 z-50 md:hidden flex justify-around items-center py-3 px-4 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
        <a href="{{ url('/') }}"
            class="flex flex-col items-center flex-1 {{ request()->is('/') ? 'text-black' : 'text-gray-400 hover:text-gray-600' }}">
            <svg class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="{{ request()->is('/') ? '2.5' : '1.5' }}"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-[10px] font-medium tracking-wide">Home</span>
        </a>
        <a href="{{ route('shop') }}"
            class="flex flex-col items-center flex-1 {{ request()->is('shop*') ? 'text-black' : 'text-gray-400 hover:text-gray-600' }}">
            <svg class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="{{ request()->is('shop*') ? '2.5' : '1.5' }}"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span class="text-[10px] font-medium tracking-wide">Shop</span>
        </a>
        <a href="#" class="flex flex-col items-center flex-1 text-gray-400 hover:text-gray-600">
            <svg class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            <span class="text-[10px] font-medium tracking-wide">Wishlist</span>
        </a>
        <a href="{{ route('profile.edit') }}"
            class="flex flex-col items-center flex-1 {{ request()->is('profile*') ? 'text-black' : 'text-gray-400 hover:text-gray-600' }}">
            <svg class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="{{ request()->is('profile*') ? '2.5' : '1.5' }}"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="text-[10px] font-medium tracking-wide">Profile</span>
        </a>
    </div>
</body>

</html>