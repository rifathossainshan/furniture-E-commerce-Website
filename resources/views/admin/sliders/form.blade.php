@extends('layouts.admin')

@section('header', $slider->exists ? 'Edit Slider' : 'Add Slider')

@section('content')
    <div class="bg-white rounded shadow p-6 max-w-2xl mx-auto">
        <form action="{{ $slider->exists ? route('admin.sliders.update', $slider) : route('admin.sliders.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if($slider->exists)
                @method('PUT')
            @endif

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                <input type="text" name="title" value="{{ old('title', $slider->title) }}"
                    class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Subtitle</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $slider->subtitle) }}"
                    class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                @error('subtitle') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Button Text</label>
                    <input type="text" name="button_text" value="{{ old('button_text', $slider->button_text) }}"
                        class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                    @error('button_text') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Button Link URL</label>
                    <input type="text" name="button_link" value="{{ old('button_link', $slider->button_link) }}"
                        class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900"
                        placeholder="/shop">
                    @error('button_link') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Slider Image <span
                        class="text-red-500">*</span></label>
                <input type="file" name="image" class="w-full" {{ !$slider->exists ? 'required' : '' }}>
                <p class="text-xs text-gray-500 mt-1">For best results, use a wide, high-resolution image.</p>
                @if($slider->image)
                    <div class="mt-2 text-sm text-gray-500">Current Image: <img src="{{ asset($slider->image) }}"
                            class="w-48 mt-1 rounded object-cover"></div>
                @endif
                @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6 flex items-center space-x-6">
                <!-- Status Checkbox -->
                <div class="flex items-center">
                    <input type="hidden" name="status" value="0">
                    <input type="checkbox" name="status" value="1" {{ old('status', $slider->status ?? true) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-gray-900 shadow-sm focus:border-gray-900 focus:ring focus:ring-gray-900 focus:ring-opacity-50">
                    <label class="ml-2 block text-gray-700 text-sm font-bold">Active</label>
                </div>
                
                <!-- Show Text Checkbox -->
                <div class="flex items-center">
                    <input type="hidden" name="show_text" value="0">
                    <input type="checkbox" name="show_text" value="1" {{ old('show_text', $slider->show_text ?? true) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-gray-900 shadow-sm focus:border-gray-900 focus:ring focus:ring-gray-900 focus:ring-opacity-50">
                    <label class="ml-2 block text-gray-700 text-sm font-bold">Show Text on Banner</label>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    {{ $slider->exists ? 'Update Slider' : 'Save Slider' }}
                </button>
                <a href="{{ route('admin.sliders.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
            </div>
        </form>
    </div>
@endsection