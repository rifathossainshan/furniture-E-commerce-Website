<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Musfiq Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans antialiased text-gray-900">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

        <!-- Sidebar Backdrop -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-40 bg-gray-900 bg-opacity-50 md:hidden"
            @click="sidebarOpen = false" style="display: none;" x-transition.opacity></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 text-white flex-shrink-0 flex flex-col transition-transform duration-300 ease-in-out -translate-x-full md:static md:translate-x-0 h-full">
            <div class="p-6 text-2xl font-bold border-b border-gray-800 flex justify-between items-center">
                <span>Musfiq</span>
                <button type="button" @click="sidebarOpen = false"
                    class="md:hidden p-2 -mr-2 text-gray-400 hover:text-white focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}"
                    class="block px-4 py-2 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 text-gray-300' }}">Dashboard</a>
                <a href="{{ route('admin.orders.index') }}"
                    class="block px-4 py-2 rounded {{ request()->routeIs('admin.orders.*') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 text-gray-300' }}">Orders</a>
                <a href="{{ route('admin.products.index') }}"
                    class="block px-4 py-2 rounded {{ request()->routeIs('admin.products.*') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 text-gray-300' }}">Products</a>
                <a href="{{ route('admin.categories.index') }}"
                    class="block px-4 py-2 rounded {{ request()->routeIs('admin.categories.*') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 text-gray-300' }}">Categories</a>
                <a href="{{ route('admin.sliders.index') }}"
                    class="block px-4 py-2 rounded {{ request()->routeIs('admin.sliders.*') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 text-gray-300' }}">Sliders</a>
                <a href="{{ route('admin.vouchers.index') }}"
                    class="block px-4 py-2 rounded {{ request()->routeIs('admin.vouchers.*') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 text-gray-300' }}">Vouchers</a>
                <a href="{{ route('admin.settings.index') }}"
                    class="block px-4 py-2 rounded {{ request()->routeIs('admin.settings.*') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 text-gray-300' }}">Settings</a>
            </nav>
            <div class="p-4 border-t border-gray-800 pb-8 md:pb-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 rounded text-red-400 hover:bg-gray-800">Logout</button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden w-full relative">
            <header class="bg-white shadow px-4 md:px-6 py-4 flex items-center justify-between z-10">
                <div class="flex items-center">
                    <button type="button" @click="sidebarOpen = true"
                        class="text-gray-500 hover:text-gray-700 focus:outline-none md:hidden mr-4 p-1">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <h1 class="text-lg md:text-xl font-semibold text-gray-800 truncate">@yield('header', 'Dashboard')
                    </h1>
                </div>
                <div class="text-sm text-gray-600 hidden sm:block">Welcome, {{ auth()->user()->name }}</div>
                <div class="text-sm text-gray-600 sm:hidden">Admin</div>
            </header>
            <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 md:p-6 pb-20 md:pb-6">
                <!-- Session Alerts -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>