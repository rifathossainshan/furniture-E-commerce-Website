@extends('layouts.admin')

@section('header', 'Orders')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Manage Orders</h2>
    </div>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-max">
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
                    <th
                        class="py-3 px-6 bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider text-right">
                        Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-6 border-b border-gray-200 text-sm font-bold text-gray-900">
                            #{{ $order->order_number }}</td>
                        <td class="py-4 px-6 border-b border-gray-200 text-sm text-gray-700">
                            {{ $order->user->name }}<br>
                            <span class="text-xs text-gray-500">{{ $order->user->email }}</span>
                        </td>
                        <td class="py-4 px-6 border-b border-gray-200 text-sm font-semibold text-gray-900">
                            ৳{{ number_format($order->final_amount, 2) }}</td>
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
                        <td class="py-4 px-6 border-b border-gray-200 text-sm text-gray-700">
                            {{ $order->created_at->format('M d, Y h:i A') }}</td>
                        <td class="py-4 px-6 border-b border-gray-200 text-sm text-right">
                            <a href="{{ route('admin.orders.show', $order) }}"
                                class="text-indigo-600 hover:text-indigo-900 font-medium">View / Update</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 px-6 text-center text-gray-500">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection