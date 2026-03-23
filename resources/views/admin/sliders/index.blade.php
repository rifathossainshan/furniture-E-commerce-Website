@extends('layouts.admin')

@section('header', 'Sliders')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Manage Sliders</h2>
        <a href="{{ route('admin.sliders.create') }}" class="px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-800">Add
            Slider</a>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr>
                    <th
                        class="py-3 px-6 bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Image</th>
                    <th
                        class="py-3 px-6 bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Text / Content</th>
                    <th
                        class="py-3 px-6 bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Status</th>
                    <th
                        class="py-3 px-6 bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider text-right">
                        Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sliders as $slider)
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-6 border-b border-gray-200">
                            <img src="{{ asset('storage/' . $slider->image) }}"
                                class="w-32 h-16 object-cover rounded shadow-sm">
                        </td>
                        <td class="py-4 px-6 border-b border-gray-200 text-sm">
                            <p class="font-bold text-gray-900">{{ $slider->title ?? 'No Title' }}</p>
                            <p class="text-gray-500 text-xs">{{ $slider->subtitle ?? 'No Subtitle' }}</p>
                        </td>
                        <td class="py-4 px-6 border-b border-gray-200 text-sm">
                            <span
                                class="px-2 py-1 leading-tight rounded-full text-xs font-semibold {{ $slider->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $slider->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="py-4 px-6 border-b border-gray-200 text-sm text-right">
                            <a href="{{ route('admin.sliders.edit', $slider) }}"
                                class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                            <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="inline-block"
                                onsubmit="return confirm('Delete this slider?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-8 px-6 text-center text-gray-500">No sliders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection