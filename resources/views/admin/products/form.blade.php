@extends('layouts.admin')

@section('header', $product->exists ? 'Edit Product' : 'Add Product')

@section('content')
    <div class="bg-white rounded shadow p-6 max-w-4xl mx-auto flex flex-col md:flex-row gap-8">
        <div class="flex-1">
            <form action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if($product->exists)
                    @method('PUT')
                @endif

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Product Name <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}"
                        class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900" required>
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Price ($) <span
                                class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900"
                            required>
                        @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Stock <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900"
                            required>
                        @error('stock') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                    <select name="category_id"
                        class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                        <option value="">None</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">{{ old('description', $product->description) }}</textarea>
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Primary Product Image</label>
                    <input type="file" name="image" class="w-full border border-gray-300 p-2 rounded">
                    @if($product->image)
                        <div class="mt-2 text-sm text-gray-500">Current Image: <img
                                src="{{ asset('storage/' . $product->image) }}" class="w-32 mt-2 rounded object-cover shadow">
                        </div>
                    @endif
                    @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Gallery Images</label>
                    <input type="file" name="images[]" multiple class="w-full border border-gray-300 p-2 rounded">
                    <p class="text-xs text-gray-500 mt-1">Select multiple images to create a product gallery slider.</p>
                    @error('images.*') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6 flex space-x-6">
                    <div class="flex items-center">
                        <input type="hidden" name="status" value="0">
                        <input type="checkbox" name="status" value="1" {{ old('status', $product->status ?? true) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-gray-900 shadow-sm focus:border-gray-900 focus:ring focus:ring-gray-900 focus:ring-opacity-50">
                        <label class="ml-2 block text-gray-700 text-sm font-bold">Active</label>
                    </div>
                    <div class="flex items-center">
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-gray-900 shadow-sm focus:border-gray-900 focus:ring focus:ring-gray-900 focus:ring-opacity-50">
                        <label class="ml-2 block text-gray-700 text-sm font-bold">Featured Product</label>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit"
                        class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline">
                        {{ $product->exists ? 'Update Product' : 'Save Product' }}
                    </button>
                    <a href="{{ route('admin.products.index') }}"
                        class="text-gray-600 hover:text-gray-900 font-medium">Cancel</a>
                </div>
            </form>

            @if(is_array($product->images) && count($product->images) > 0)
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Existing Gallery Images</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($product->images as $index => $img)
                            <div class="relative group border p-1 rounded shadow-sm">
                                <img src="{{ asset('storage/' . $img) }}" class="w-full h-32 rounded object-cover">
                                <form action="{{ route('admin.products.image.delete', ['product' => $product->id, 'index' => $index]) }}" method="POST" class="absolute top-2 right-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Are you sure you want to delete this gallery image?')"
                                            class="bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition hover:bg-red-700 shadow-md">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection