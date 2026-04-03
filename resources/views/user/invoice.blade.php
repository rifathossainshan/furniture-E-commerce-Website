<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; padding: 40px 20px; }
        .invoice-box { max-width: 800px; margin: auto; padding: 40px; border: 1px solid #eee; box-shadow: 0 4px 6px rgba(0,0,0,0.05); background: white; }
        @media print {
            body { background: white; padding: 0; }
            .invoice-box { box-shadow: none; border: none; padding: 0; }
            .no-print { display: none; }
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

    fbq('init', '1422517276225385');
    fbq('track', 'PageView');
    </script>
    <noscript>
    <img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=1422517276225385&ev=PageView&noscript=1"/>
    </noscript>
    <!-- End Meta Pixel Code -->
</head>
<body>

@if(session('success'))
<script>
fbq('track', 'Purchase', {
  content_ids: [{!! implode(', ', $order->items->pluck('product_id')->map(function($id) { return "'" . $id . "'"; })->toArray()) !!}],
  content_type: 'product',
  value: {{ max(0, $order->final_amount) }},
  currency: 'BDT',
  num_items: {{ $order->items->sum('quantity') }}
});
</script>
@endif

@php
    $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
@endphp

<div class="max-w-3xl mx-auto mb-6 flex justify-between items-center no-print">
    <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Dashboard
    </a>
    <button onclick="window.print()" class="bg-black text-white px-4 py-2 rounded shadow hover:bg-gray-800 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
        Print Invoice
    </button>
</div>

<div class="invoice-box">
    
    <!-- Header -->
    <div class="flex justify-between items-start mb-12">
        <div>
            @if(isset($settings['site_logo']))
                <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="{{ $settings['site_name'] ?? 'Logo' }}" style="max-height: 60px;">
            @else
                <h1 class="text-3xl font-bold tracking-widest uppercase">{{ $settings['site_name'] ?? 'Store Name' }}</h1>
            @endif
            <div class="mt-4 text-gray-500 text-sm">
                <p>{{ $settings['contact_address'] ?? '123 Store Address, City, Country' }}</p>
                <p>{{ $settings['contact_email'] ?? 'support@store.com' }} | {{ $settings['contact_phone'] ?? '+123456789' }}</p>
            </div>
        </div>
        <div class="text-right">
            <h2 class="text-4xl font-light text-gray-800 mb-2 uppercase tracking-wide">Invoice</h2>
            <p class="text-gray-500 font-medium">#{{ $order->order_number }}</p>
            <p class="text-gray-500 text-sm mt-1">Date: {{ $order->created_at->format('M d, Y') }}</p>
        </div>
    </div>

    <!-- Billing Info -->
    <div class="mb-12">
        <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-widest border-b pb-2 mb-4">Billed To</h3>
        <p class="font-bold text-gray-900">{{ $order->user->name ?? 'Guest' }}</p>
        <p class="text-gray-600 mt-1">{{ $order->user->email ?? '' }}</p>
        <p class="text-gray-600 mt-1">{{ $order->shipping_address }}</p>
    </div>

    <!-- Items Table -->
    <table class="w-full text-left mb-8 border-collapse">
        <thead>
            <tr class="border-b-2 border-gray-800">
                <th class="py-3 font-semibold text-gray-800 uppercase tracking-wider text-sm">Item</th>
                <th class="py-3 font-semibold text-gray-800 uppercase tracking-wider text-sm text-center">Qty</th>
                <th class="py-3 font-semibold text-gray-800 uppercase tracking-wider text-sm text-right">Price</th>
                <th class="py-3 font-semibold text-gray-800 uppercase tracking-wider text-sm text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr class="border-b border-gray-200">
                <td class="py-4 text-gray-800 font-medium">{{ $item->product->name ?? 'Deleted Product' }}</td>
                <td class="py-4 text-gray-600 text-center">{{ $item->quantity }}</td>
                <td class="py-4 text-gray-600 text-right">৳{{ number_format($item->price, 2) }}</td>
                <td class="py-4 text-gray-900 font-bold text-right">৳{{ number_format($item->quantity * $item->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <div class="flex justify-end">
        <div class="w-1/2">
            <div class="flex justify-between py-2 border-b border-gray-100">
                <span class="text-gray-600">Subtotal</span>
                <span class="font-medium text-gray-900">৳{{ number_format($order->total_amount, 2) }}</span>
            </div>
            @if($order->discount_amount > 0)
            <div class="flex justify-between py-2 border-b border-gray-100 text-red-600">
                <span>Discount</span>
                <span>- ৳{{ number_format($order->discount_amount, 2) }}</span>
            </div>
            @endif
            <div class="flex justify-between py-2 border-b border-gray-100">
                <span class="text-gray-600">Delivery Charge</span>
                <span class="font-medium text-gray-900">৳{{ number_format($order->delivery_charge, 2) }}</span>
            </div>
            <div class="flex justify-between py-3 border-t-2 border-gray-800 mt-2 text-lg">
                <span class="font-bold text-gray-900 uppercase tracking-wider text-sm mt-1">Grand Total</span>
                <span class="font-bold text-black">৳{{ number_format($order->final_amount, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="mt-20 pt-8 border-t border-gray-200 text-center text-gray-500 text-sm">
        <p>Thank you for your business!</p>
        <p class="mt-1">If you have any questions about this invoice, please contact us at {{ $settings['contact_email'] ?? 'support@store.com' }}</p>
    </div>
</div>

</body>
</html>
