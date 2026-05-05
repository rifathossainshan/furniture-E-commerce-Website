@extends('layouts.admin')

@section('header', 'Products')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Manage Products</h2>
        <a href="{{ route('admin.products.create') }}"
            class="px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-800">Add Product</a>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th
                            class="py-3 px-6 bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Product</th>
                        <th
                            class="py-3 px-6 bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Category</th>
                        <th
                            class="py-3 px-6 bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Price</th>
                        <th
                            class="py-3 px-6 bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Stock</th>
                        <th
                            class="py-3 px-6 bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status</th>
                        <th
                            class="py-3 px-6 bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 px-6 border-b border-gray-200 text-sm text-gray-900 flex items-center gap-3">
                                @if($product->image)
                                    <img src="{{ asset($product->image) }}" class="w-10 h-10 rounded object-cover">
                                @else
                                    <div class="w-10 h-10 rounded bg-gray-200 flex items-center justify-center text-gray-500">No Img
                                    </div>
                                @endif
                                {{ $product->name }}
                                @if($product->is_featured)
                                    <span
                                        class="ml-2 px-2 py-0.5 rounded text-[10px] bg-yellow-100 text-yellow-800 font-bold uppercase">Featured</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 border-b border-gray-200 text-sm text-gray-700">
                                {{ $product->category->name ?? 'None' }}</td>
                            <td class="py-4 px-6 border-b border-gray-200 text-sm font-semibold text-gray-900">
                                ?{{ number_format($product->price, 2) }}</td>
                            <td class="py-4 px-6 border-b border-gray-200 text-sm text-gray-700">{{ $product->stock }}</td>
                            <td class="py-4 px-6 border-b border-gray-200 text-sm">
                                <span
                                    class="px-2 py-1 leading-tight rounded-full text-xs font-semibold {{ $product->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 border-b border-gray-200 text-sm text-right">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                    class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block flex items-center justify-end"
                                    x-data="{ confirming: false }"
                                    @submit.prevent="if(!confirming) { confirming = true; } else { $el.submit(); }">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" :class="confirming ? 'text-white bg-red-600 px-2 rounded hover:bg-red-700' : 'text-red-600 hover:text-red-900'" x-text="confirming ? 'Are you sure?' : 'Delete'"></button>
                                    <button type="button" x-show="confirming" @click="confirming = false" x-cloak class="text-gray-500 text-xs ml-2 hover:text-gray-800">Cancel</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 px-6 text-center text-gray-500">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
