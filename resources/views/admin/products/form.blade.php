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

                <div class="mb-4" x-data="{ btnType: '{{ old('button_type', $product->button_type ?? 'default') }}' }">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Button Type (On Product Cards)</label>
                    <select name="button_type" x-model="btnType" class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900" required>
                        <option value="default">Default (Inherit from Category)</option>
                        <option value="buy_now">Buy Now / Add to Cart</option>
                        <option value="inquiry">Inquiry Only</option>
                        <option value="inquiry_booking">Inquiry & Booking</option>
                        <option value="inquiry_buy_now">Inquiry & Buy Now</option>
                    </select>
                    @error('button_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                    <div x-show="btnType === 'inquiry' || btnType === 'inquiry_booking' || btnType === 'inquiry_buy_now'" class="mt-4 p-4 border border-gray-200 rounded bg-stone-50" x-cloak>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Product Specific WhatsApp Number</label>
                        <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $product->whatsapp_number) }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900" placeholder="e.g. +8801XXXXXXXXX">
                        <p class="text-xs text-gray-500 mt-1">Leave blank to use the global WhatsApp number.</p>
                        @error('whatsapp_number') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">{{ old('description', $product->description) }}</textarea>
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- SEO Fields -->
                <div class="mb-6 p-4 border border-gray-200 rounded bg-gray-50">
                    <h3 class="block text-gray-700 text-sm font-bold mb-4 border-b pb-2">Search Engine Optimization (SEO)</h3>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900" placeholder="Optional. Max 60 characters for best results">
                        @error('meta_title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Meta Keywords</label>
                        <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $product->meta_keywords) }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900" placeholder="e.g. elegant dress, summer collection, floral">
                        @error('meta_keywords') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Meta Description</label>
                        <textarea name="meta_description" rows="2"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900" placeholder="Optional. Max 160 characters.">{{ old('meta_description', $product->meta_description) }}</textarea>
                        @error('meta_description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Dynamic Product Attributes -->
                <div class="mb-6 p-4 border border-gray-200 rounded bg-gray-50" x-data="attributeHandler()">
                    <div class="flex justify-between items-center mb-4">
                        <label class="block text-gray-700 text-sm font-bold">Product Attributes</label>
                        <button type="button" @click="addAttribute()" class="text-xs bg-gray-900 hover:bg-gray-800 text-white font-semibold py-1.5 px-3 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-gray-900 transition">
                            + Add Attribute
                        </button>
                    </div>
                    
                    <div class="space-y-3">
                        <template x-for="(attr, index) in attributes" :key="index">
                            <div class="flex items-center gap-3 bg-white p-2 border border-gray-200 rounded shadow-sm">
                                <div class="flex-1">
                                    <input type="text" :name="'attributes[name][' + index + ']'" x-model="attr.name" placeholder="Name (e.g. Size, Color)" class="w-full border-gray-300 rounded shadow-sm text-sm focus:border-gray-900 focus:ring-gray-900" required>
                                </div>
                                <div class="flex-1">
                                    <input type="text" :name="'attributes[value][' + index + ']'" x-model="attr.value" placeholder="Value (e.g. XL, Red)" class="w-full border-gray-300 rounded shadow-sm text-sm focus:border-gray-900 focus:ring-gray-900" required>
                                </div>
                                <div class="w-8 flex justify-center">
                                    <button type="button" @click="removeAttribute(index)" class="text-red-500 hover:text-red-700 focus:outline-none transition" title="Remove Attribute">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                        <div x-show="attributes.length === 0" class="text-sm text-gray-500 italic text-center py-4 bg-white border border-dashed border-gray-300 rounded">No dynamic attributes added yet. Click "+ Add Attribute" to start.</div>
                    </div>
                </div>

                <script>
                    function attributeHandler() {
                        return {
                            attributes: @json($product->exists ? $product->attributes->map(fn($a) => ['name' => $a->name, 'value' => $a->value]) : []),
                            addAttribute() {
                                this.attributes.push({ name: '', value: '' });
                            },
                            removeAttribute(index) {
                                this.attributes.splice(index, 1);
                            }
                        }
                    }
                </script>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Primary Product Image</label>
                    <input type="file" name="image" class="w-full border border-gray-300 p-2 rounded">
                    @if($product->image)
                        <div class="mt-2 text-sm text-gray-500">Current Image: <img
                                src="{{ asset($product->image) }}" class="w-32 mt-2 rounded object-cover shadow">
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
                                <img src="{{ asset($img) }}" class="w-full h-32 rounded object-cover">
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
