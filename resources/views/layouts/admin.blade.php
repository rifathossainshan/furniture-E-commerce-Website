<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Musfiq Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans antialiased text-gray-900">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white flex-shrink-0 flex flex-col">
            <div class="p-6 text-2xl font-bold border-b border-gray-800">
                Musfiq Admin
            </div>
            <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}"
                    class="block px-4 py-2 rounded bg-gray-800 text-gray-100">Dashboard</a>
                <a href="{{ route('admin.orders.index') }}"
                    class="block px-4 py-2 rounded hover:bg-gray-800 text-gray-300">Orders</a>
                <a href="{{ route('admin.products.index') }}"
                    class="block px-4 py-2 rounded hover:bg-gray-800 text-gray-300">Products</a>
                <a href="{{ route('admin.categories.index') }}"
                    class="block px-4 py-2 rounded hover:bg-gray-800 text-gray-300">Categories</a>
                <a href="{{ route('admin.sliders.index') }}"
                    class="block px-4 py-2 rounded hover:bg-gray-800 text-gray-300">Sliders</a>
                <a href="{{ route('admin.vouchers.index') }}"
                    class="block px-4 py-2 rounded hover:bg-gray-800 text-gray-300">Vouchers</a>
                <a href="{{ route('admin.settings.index') }}"
                    class="block px-4 py-2 rounded hover:bg-gray-800 text-gray-300">Settings</a>
            </nav>
            <div class="p-4 border-t border-gray-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-fulltext-left px-4 py-2 rounded text-red-400 hover:bg-gray-800 w-full text-left">Logout</button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden">
            <header class="bg-white shadow px-6 py-4 flex items-center justify-between">
                <h1 class="text-xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h1>
                <div class="text-sm text-gray-600">Welcome, {{ auth()->user()->name }}</div>
            </header>
            <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
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