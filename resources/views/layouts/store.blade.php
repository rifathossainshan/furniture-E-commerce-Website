@php
    $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $settings['site_name'] ?? config('app.name', 'My Store'))</title>
    @if(!empty($settings['site_logo']))
        <link rel="icon" type="image/png" href="{{ asset($settings['site_logo']) }}">
    @endif
    @yield('meta')

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

        /* Custom UI Elements */
        .btn-primary {
            background: linear-gradient(135deg, #ff6a8b, #a83279);
            color: #ffffff !important;
            padding: 12px 20px;
            border-radius: 25px;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #ff4f75, #8e2a68);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(168, 50, 121, 0.4);
        }
    </style>

    <!-- Meta Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');

    fbq('init', '26605583772434594');
    fbq('track', 'PageView');
    </script>
    <noscript>
    <img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=26605583772434594&ev=PageView&noscript=1"/>
    </noscript>
    <!-- End Meta Pixel Code -->
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
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center justify-start">
                    <a href="{{ url('/') }}" class="text-2xl font-serif font-semibold tracking-wider text-gray-900">
                        @if(isset($settings['site_logo']))
                            <img src="{{ asset($settings['site_logo']) }}" alt="Logo" style="height: 60px; width: auto; object-fit: contain; transform: scale(1.4); transform-origin: left center; position: relative; z-index: 10;">
                        @else
                            {{ $settings['site_name'] ?? config('app.name', 'My Store') }}
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

                <!-- Icons & Hamburger -->
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
                                class="absolute -top-1.5 -right-2 bg-[#9b2a59] text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full leading-none">{{ count(session('cart')) }}</span>
                        @endif
                    </a>
                    <a href="{{ route('wishlist.index') }}" class="text-gray-600 hover:text-gray-900 transition relative hidden md:block">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        @if(session('wishlist') && count(session('wishlist')) > 0)
                            <span
                                class="absolute -top-1.5 -right-2 bg-[#E4405F] text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full leading-none">{{ count(session('wishlist')) }}</span>
                        @endif
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="text-gray-600 hover:text-gray-900 transition hidden md:block">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </a>

                    <!-- Hamburger (Mobile) -->
                    <div class="flex items-center md:hidden ml-2">
                        <button @click="mobileMenuOpen = !mobileMenuOpen"
                            class="text-gray-600 hover:text-gray-900 focus:outline-none focus:text-gray-900 p-1.5 bg-[#fcf1f4] hover:bg-[#f3e5e9] rounded-md transition">
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
                    @if(isset($settings['site_logo']))
                        <img src="{{ asset($settings['site_logo']) }}" alt="Logo" style="height: 96px; width: auto; object-fit: contain;">
                    @else
                        {{ $settings['site_name'] ?? config('app.name', 'My Store') }}
                    @endif
                </a>
                <p class="text-sm text-gray-500 leading-relaxed">
                    {{ $settings['about_us'] ?? 'Elevating elegance and style.' }}
                </p>
                <div class="flex items-center space-x-4 pt-2">
                    <a href="{{ $settings['social_facebook'] ?? '#' }}" style="color: #1877F2;" class="hover:opacity-80 transition" target="_blank" rel="noopener noreferrer">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="{{ $settings['social_instagram'] ?? '#' }}" style="color: #E4405F;" class="hover:opacity-80 transition" target="_blank" rel="noopener noreferrer">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="{{ $settings['social_whatsapp'] ?? '#' }}" style="color: #25D366;" class="hover:opacity-80 transition" target="_blank" rel="noopener noreferrer">
                        <span class="sr-only">WhatsApp</span>
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor">
                            <path d="M12.01 2.016A9.957 9.957 0 0 0 2 11.972c0 1.76.452 3.483 1.31 5L1.97 21.996l5.165-1.353c1.472.8 3.12 1.222 4.816 1.224h.007a9.954 9.954 0 0 0 9.954-9.956 9.932 9.932 0 0 0-2.916-7.042A9.936 9.936 0 0 0 12.01 2.016zm5.467 14.183c-.22.618-1.282 1.155-1.75 1.26-.432.096-1.045.15-3.158-.727-2.555-1.055-4.16-3.648-4.286-3.818-.127-.17-1.02-1.358-1.02-2.59 0-1.23.638-1.838.864-2.067.226-.228.496-.286.66-.286.166 0 .332 0 .47.008.142.007.336-.055.526.403.2.474.678 1.654.738 1.77.06.122.1.258.016.425-.082.168-.126.27-.253.42l-.38.43c-.126.12-.262.253-.116.505.148.253.66 1.09 1.42 1.766.976.873 1.8 1.144 2.05 1.265.25.12.398.11.545-.062.148-.17.64-.745.832-1.02.168-.19.474-.328.678-.436.202-.116 1.284-.608 1.505-.715.22-.11.368-.163.424-.252.056-.09.056-.522-.164-1.14z"/>
                        </svg>
                    </a>
                </div>
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
                    <li class="flex items-start">
                        <svg class="h-4 w-4 mr-2 mt-0.5 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>{{ $settings['contact_address'] ?? '123 Elegance St, NY 10001' }}</span>
                    </li>
                    <li class="flex items-center mt-2">
                        <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <a href="mailto:{{ $settings['contact_email'] ?? 'support@example.com' }}"
                            class="hover:text-black transition">{{ $settings['contact_email'] ?? 'support@example.com'
                            }}</a>
                    </li>
                    <li class="flex items-center mt-2">
                        <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:{{ $settings['contact_phone'] ?? '+1 234 567 890' }}"
                            class="hover:text-black transition">{{ $settings['contact_phone'] ?? '+1 234 567 890' }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div
            class="text-center text-xs text-gray-400 mt-12 border-t border-gray-200 pt-8 max-w-7xl mx-auto px-4 uppercase tracking-widest font-semibold flex flex-col md:flex-row justify-between items-center gap-4">
            <span>&copy; {{ date('Y') }} {{ $settings['footer_copyright'] ?? (config('app.name', 'My Store') . '. All rights reserved.') }}</span>
            <span class="normal-case tracking-normal">Developed by <a href="https://rifathossainshan.github.io/Portfolio/" target="_blank" class="font-bold hover:text-gray-900 transition">Shan</a></span>
            <span class="flex gap-4">
                <a href="#" class="hover:text-gray-900 transition">Privacy</a>
                <a href="#" class="hover:text-gray-900 transition">Terms</a>
            </span>
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
        <a href="{{ route('wishlist.index') }}" class="flex flex-col items-center flex-1 relative {{ request()->is('wishlist*') ? 'text-black' : 'text-gray-400 hover:text-gray-600' }}">
            <svg class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->is('wishlist*') ? '2.5' : '1.5' }}"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            @if(session('wishlist') && count(session('wishlist')) > 0)
                <span class="absolute top-0 right-4 bg-[#E4405F] text-white text-[9px] font-bold px-1 rounded-full leading-none border border-white">{{ count(session('wishlist')) }}</span>
            @endif
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
