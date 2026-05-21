@extends('layouts.admin')

@section('header', $category->exists ? 'Edit Category' : 'Add Category')

@section('content')
    <div class="bg-white rounded shadow p-6 max-w-2xl mx-auto">
        <form
            action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if($category->exists)
                @method('PUT')
            @endif

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Category Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}"
                    class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900" required>
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Description / Subtitle</label>
                <textarea name="description" rows="3" class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">{{ old('description', $category->description) }}</textarea>
                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Image</label>
                <input type="file" name="image" class="w-full">
                @if($category->image)
                    <div class="mt-2 text-sm text-gray-500">Current Image: <img src="{{ asset($category->image) }}"
                            class="h-16 mt-1 rounded object-cover"></div>
                @endif
                @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Text Color (On Image)</label>
                <select name="text_color" class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900" required>
                    <option value="black" {{ old('text_color', $category->text_color) == 'black' ? 'selected' : '' }}>Black</option>
                    <option value="white" {{ old('text_color', $category->text_color) == 'white' ? 'selected' : '' }}>White</option>
                    <option value="red" {{ old('text_color', $category->text_color) == 'red' ? 'selected' : '' }}>Red</option>
                    <option value="golden" {{ old('text_color', $category->text_color) == 'golden' ? 'selected' : '' }}>Golden</option>
                    <option value="blue" {{ old('text_color', $category->text_color) == 'blue' ? 'selected' : '' }}>Blue</option>
                </select>
                @error('text_color') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Subtitle Color</label>
                <select name="subtitle_color" class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                    <option value="" {{ old('subtitle_color', $category->subtitle_color) == '' ? 'selected' : '' }}>Same as Text Color</option>
                    <option value="black" {{ old('subtitle_color', $category->subtitle_color) == 'black' ? 'selected' : '' }}>Black</option>
                    <option value="white" {{ old('subtitle_color', $category->subtitle_color) == 'white' ? 'selected' : '' }}>White</option>
                    <option value="red" {{ old('subtitle_color', $category->subtitle_color) == 'red' ? 'selected' : '' }}>Red</option>
                    <option value="golden" {{ old('subtitle_color', $category->subtitle_color) == 'golden' ? 'selected' : '' }}>Golden</option>
                    <option value="blue" {{ old('subtitle_color', $category->subtitle_color) == 'blue' ? 'selected' : '' }}>Blue</option>
                </select>
                @error('subtitle_color') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6 flex items-center">
                <input type="hidden" name="status" value="0">
                <input type="checkbox" name="status" value="1" {{ old('status', $category->status ?? true) ? 'checked' : '' }}
                    class="rounded border-gray-300 text-gray-900 shadow-sm focus:border-gray-900 focus:ring focus:ring-gray-900 focus:ring-opacity-50">
                <label class="ml-2 block text-gray-700 text-sm font-bold">Active</label>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    {{ $category->exists ? 'Update Category' : 'Save Category' }}
                </button>
                <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
            </div>
        </form>
    </div>
@endsection
