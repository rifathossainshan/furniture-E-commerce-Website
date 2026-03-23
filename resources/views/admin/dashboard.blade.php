@extends('layouts.admin')

@section('header', 'Dashboard Overview')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded shadow p-6 border-l-4 border-blue-500">
            <h3 class="text-gray-500 text-sm font-semibold uppercase tracking-wider mb-2">Total Orders</h3>
            <p class="text-3xl font-bold text-gray-800">{{ $totalOrders }}</p>
        </div>
        <div class="bg-white rounded shadow p-6 border-l-4 border-green-500">
            <h3 class="text-gray-500 text-sm font-semibold uppercase tracking-wider mb-2">Total Revenue</h3>
            <p class="text-3xl font-bold text-gray-800">${{ number_format($totalRevenue, 2) }}</p>
        </div>
        <div class="bg-white rounded shadow p-6 border-l-4 border-purple-500">
            <h3 class="text-gray-500 text-sm font-semibold uppercase tracking-wider mb-2">Total Products</h3>
            <p class="text-3xl font-bold text-gray-800">{{ $totalProducts }}</p>
        </div>
        <div class="bg-white rounded shadow p-6 border-l-4 border-yellow-500">
            <h3 class="text-gray-500 text-sm font-semibold uppercase tracking-wider mb-2">Pending Orders</h3>
            <p class="text-3xl font-bold text-gray-800">{{ $pendingOrders }}</p>
        </div>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Recent Orders</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th
                            class="py-3 px-6 bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Order ID</th>
                        <th
                            class="py-3 px-6 bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Customer</th>
                        <th
                            class="py-3 px-6 bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Amount</th>
                        <th
                            class="py-3 px-6 bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status</th>
                        <th
                            class="py-3 px-6 bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 px-6 border-b border-gray-200 text-sm text-gray-900">#{{ $order->order_number }}
                            </td>
                            <td class="py-4 px-6 border-b border-gray-200 text-sm text-gray-700">{{ $order->user->name }}</td>
                            <td class="py-4 px-6 border-b border-gray-200 text-sm text-gray-900">
                                ${{ number_format($order->final_amount, 2) }}</td>
                            <td class="py-4 px-6 border-b border-gray-200 text-sm">
                                <span class="px-2 py-1 leading-tight rounded-full text-xs font-semibold
                                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $order->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $order->status === 'shipped' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 border-b border-gray-200 text-sm text-gray-500">
                                {{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 px-6 text-center text-gray-500">No recent orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection