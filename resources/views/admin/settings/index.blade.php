@extends('layouts.admin')

@section('header', 'Site Settings')

@section('content')
    <div class="bg-white rounded shadow p-6 max-w-4xl mx-auto">
        <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-8 border-b pb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">General Info & Logo</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Site Name</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Musfiq' }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Site Logo</label>
                        <input type="file" name="site_logo" class="w-full text-sm">
                        @if(isset($settings['site_logo']))
                            <img src="{{ asset('storage/' . $settings['site_logo']) }}"
                                class="h-10 mt-2 object-contain bg-gray-100 p-1 rounded">
                        @endif
                    </div>
                </div>
            </div>

            <div class="mb-8 border-b pb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Notice Bar</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Notice Text</label>
                        <input type="text" name="notice_text"
                            value="{{ $settings['notice_text'] ?? 'FREE GLOBAL SHIPPING ON ORDERS OVER $500. [SHOP NOW]' }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                    </div>
                    <div class="flex items-center mt-6">
                        <input type="hidden" name="notice_active" value="0">
                        <input type="checkbox" name="notice_active" value="1" {{ ($settings['notice_active'] ?? '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-gray-900 shadow-sm focus:border-gray-900">
                        <label class="ml-2 block text-gray-700 text-sm font-bold">Show Notice Bar</label>
                    </div>
                </div>
            </div>

            <div class="mb-8 border-b pb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Contact & Social</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                        <input type="email" name="contact_email"
                            value="{{ $settings['contact_email'] ?? 'support@musfiq.com' }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Phone Number</label>
                        <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '+1 234 567 890' }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Office Address</label>
                        <textarea name="contact_address" rows="2"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">{{ $settings['contact_address'] ?? '123 Elegance St, NY 10001' }}</textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Facebook Link</label>
                        <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? '#' }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Instagram Link</label>
                        <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? '#' }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Copyright Text</label>
                        <input type="text" name="footer_copyright"
                            value="{{ $settings['footer_copyright'] ?? 'Musfiq. All rights reserved.' }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Office Address</label>
                        <textarea name="contact_address" rows="2"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">{{ $settings['contact_address'] ?? '123 Elegance St, Fashion District, NY 10001' }}</textarea>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Policies & Pages</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">About Us</label>
                        <textarea name="about_us" rows="4"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">{{ $settings['about_us'] ?? 'Welcome to Musfiq. We redefine elegance.' }}</textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Return Policy</label>
                        <textarea name="return_policy" rows="3"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">{{ $settings['return_policy'] ?? '30-day hassle-free return.' }}</textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Privacy Policy</label>
                        <textarea name="privacy_policy" rows="3"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">{{ $settings['privacy_policy'] ?? 'Your data is safe with us.' }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end">
                <button type="submit"
                    class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-8 rounded focus:outline-none focus:shadow-outline text-lg">
                    Save All Settings
                </button>
            </div>
        </form>
    </div>
@endsection