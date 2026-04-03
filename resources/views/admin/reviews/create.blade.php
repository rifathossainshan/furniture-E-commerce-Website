@extends('layouts.admin')

@section('header', 'Add Manual Review')

@section('content')
<div class="bg-white rounded shadow overflow-hidden max-w-4xl mx-auto">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800">Create New Review</h3>
        <a href="{{ route('admin.reviews.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
            &larr; Back to Reviews
        </a>
    </div>

    <form action="{{ route('admin.reviews.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf

        <div class="space-y-6">
            <!-- Product Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Product *</label>
                <select name="product_id" required class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Choose a Product --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                @error('product_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Customer Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Customer Name *</label>
                <input type="text" name="customer_name" required value="{{ old('customer_name') }}" class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('customer_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Rating -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Rating *</label>
                <select name="rating" required class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="5">5 - Excellent</option>
                    <option value="4">4 - Good</option>
                    <option value="3">3 - Average</option>
                    <option value="2">2 - Poor</option>
                    <option value="1">1 - Terrible</option>
                </select>
                @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Comment -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Review Comment</label>
                <textarea name="comment" rows="4" class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('comment') }}</textarea>
                @error('comment') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Review Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Review Date</label>
                <input type="datetime-local" name="review_date" value="{{ old('review_date') }}" class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <p class="text-xs text-gray-500 mt-1">Leave blank to use current date and time.</p>
                @error('review_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Images -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Images (Max 3)</label>
                <input type="file" name="images[]" multiple accept="image/*" class="w-full border border-gray-300 rounded p-2 text-sm">
                @error('images') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-8 border-t border-gray-200 pt-6">
            <button type="submit" class="text-white font-bold py-2 px-6 rounded shadow transition" style="background-color: #2563eb;">
                Save & Publish Review
            </button>
        </div>
    </form>
</div>
@endsection
