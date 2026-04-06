@extends('layouts.admin')

@section('header', 'Order Details: #' . $order->order_number)

@section('content')
    <div id="print-area" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Items Ordered</h3>
                <table class="w-full text-left">
                    <thead>
                        <tr>
                            <th class="py-2 text-sm text-gray-600 border-b">Product</th>
                            <th class="py-2 text-sm text-gray-600 border-b text-center">Unit Price</th>
                            <th class="py-2 text-sm text-gray-600 border-b text-center">Quantity</th>
                            <th class="py-2 text-sm text-gray-600 border-b text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr class="border-b">
                                <td class="py-3 flex items-center gap-3">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset($item->product->image) }}"
                                            class="w-10 h-10 object-cover rounded">
                                    @else
                                        <div class="w-10 h-10 rounded bg-gray-200"></div>
                                    @endif
                                    <div>
                                        <span class="text-sm font-medium">{{ $item->product->name ?? 'Deleted Product' }}</span>
                                        @if(!empty($item->selected_attributes))
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                @foreach($item->selected_attributes as $attrName => $attrVal)
                                                    <span class="inline-flex items-center text-[10px] font-semibold text-gray-700 bg-gray-100 border border-gray-300 rounded-full px-2 py-0.5">
                                                        <span class="font-bold mr-0.5">{{ $attrName }}:</span> {{ $attrVal }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 text-sm text-center">৳{{ number_format($item->price, 2) }}</td>
                                <td class="py-3 text-sm text-center">{{ $item->quantity }}</td>
                                <td class="py-3 text-sm text-right font-semibold">
                                    ৳{{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4 flex flex-col items-end space-y-2">
                    <div class="text-sm text-gray-600">Subtotal: <span
                            class="text-gray-900 font-medium ml-4">৳{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    @if($order->discount_amount > 0)
                        <div class="text-sm text-red-600">Discount: <span
                                class="font-medium ml-4">-৳{{ number_format($order->discount_amount, 2) }}</span></div>
                    @endif
                    <div class="text-sm text-gray-600 mt-1">Delivery Charge: <span
                            class="text-gray-900 font-medium ml-4">৳{{ number_format($order->delivery_charge ?? 0, 2) }}</span>
                    </div>
                    <div class="text-lg font-bold text-gray-900 mt-2 border-t pt-2">Total: <span
                            class="ml-4">৳{{ number_format($order->final_amount, 2) }}</span></div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Order Status</h3>
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Update Status</label>
                        <select name="status"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed
                            </option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered
                            </option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                    </div>
                    <button type="submit"
                        class="w-full bg-gray-900 text-white font-bold py-2 px-4 rounded hover:bg-gray-800">Update
                        Order</button>
                </form>
            </div>

            <div class="bg-white rounded shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Customer & Shipping</h3>
                <div class="text-sm space-y-3">
                    <div>
                        <span class="font-medium text-gray-700 block">Customer:</span>
                        <p>{{ optional($order->user)->name ?? 'Guest' }}</p>
                        <p class="text-gray-500">{{ optional($order->user)->email ?? 'No email' }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700 block">Payment Method:</span>
                        <p class="uppercase font-semibold">{{ $order->payment_method }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700 block">Shipping Address:</span>
                        <p class="text-gray-600 whitespace-pre-wrap">{{ $order->shipping_address }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700 block">Order Date:</span>
                        <p class="text-gray-600">{{ $order->created_at->format('F d, Y h:i A') }}</p>
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <button onclick="window.print()"
                        class="w-full bg-blue-50 text-blue-700 border border-blue-200 font-bold py-2 px-4 rounded hover:bg-blue-100 flex justify-center items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                            </path>
                        </svg>
                        Print Invoice
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #print-area,
            #print-area * {
                visibility: visible;
            }

            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .bg-gray-100 {
                background: white !important;
            }

            aside,
            form,
            button {
                display: none !important;
            }

            header {
                display: none !important;
            }
        }
    </style>
@endsection