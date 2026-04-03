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
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'My Store' }}"
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
                            value="{{ $settings['contact_email'] ?? 'support@example.com' }}"
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
                            value="{{ $settings['footer_copyright'] ?? 'My Store. All rights reserved.' }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">WhatsApp Link</label>
                        <input type="url" name="social_whatsapp" value="{{ $settings['social_whatsapp'] ?? '#' }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Policies & Pages</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">About Us</label>
                        <textarea name="about_us" rows="4"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">{{ $settings['about_us'] ?? 'Welcome to our store. We redefine elegance.' }}</textarea>
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

            <div class="mb-8 border-t pt-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Product Page Guarantees</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Shipping Title</label>
                        <input type="text" name="shipping_title" value="{{ $settings['shipping_title'] ?? 'Free Global Shipping' }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Shipping Subtitle</label>
                        <input type="text" name="shipping_subtitle" value="{{ $settings['shipping_subtitle'] ?? 'on orders over $500' }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Returns Title</label>
                        <input type="text" name="returns_title" value="{{ $settings['returns_title'] ?? '30-Day Free Returns' }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Returns Subtitle</label>
                        <input type="text" name="returns_subtitle" value="{{ $settings['returns_subtitle'] ?? 'No questions asked' }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                    </div>
                </div>
            </div>

            <div class="mb-8 border-t pt-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6 bg-gray-50 p-3 border-l-4 border-gray-900 rounded-r">About Page Full Configuration</h3>
                
                <h4 class="text-md font-bold text-gray-700 mb-4 mt-6 border-b pb-2">1. Hero Section</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Hero Title</label>
                        <input type="text" name="about_hero_title" value="{{ $settings['about_hero_title'] ?? 'Redefining<br>Modern Elegance' }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Hero Subtitle</label>
                        <input type="text" name="about_hero_subtitle" value="{{ $settings['about_hero_subtitle'] ?? 'Our Story' }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                    </div>
                    <!-- Hero BG Upload -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Background Image</label>
                        <input type="file" name="about_hero_bg" class="w-full text-sm">
                        @if(isset($settings['about_hero_bg']))
                            <img src="{{ asset('storage/' . $settings['about_hero_bg']) }}"
                                class="h-20 mt-2 object-cover bg-gray-100 p-1 rounded">
                        @endif
                    </div>
                </div>

                <h4 class="text-md font-bold text-gray-700 mb-4 mt-8 border-b pb-2">2. Story Section (Images & Info)</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Established Year</label>
                        <input type="text" name="about_est_year" value="{{ $settings['about_est_year'] ?? '2026' }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Collections Badge</label>
                        <input type="text" name="about_collections" value="{{ $settings['about_collections'] ?? 'Premium' }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                    </div>
                    <!-- Side BG Upload -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Side Feature Image</label>
                        <input type="file" name="about_feature_image" class="w-full text-sm">
                        @if(isset($settings['about_feature_image']))
                            <img src="{{ asset('storage/' . $settings['about_feature_image']) }}"
                                class="h-20 mt-2 object-cover bg-gray-100 p-1 rounded">
                        @endif
                    </div>
                </div>

                <h4 class="text-md font-bold text-gray-700 mb-4 mt-8 border-b pb-2">3. Core Values (3 items)</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Value 1 -->
                    <div class="bg-gray-50 p-4 border border-gray-200 rounded">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Value 1 Title</label>
                        <input type="text" name="about_core_1_title" value="{{ $settings['about_core_1_title'] ?? 'Unmatched Quality' }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900 mb-3 text-sm">
                        
                        <label class="block text-gray-700 text-sm font-bold mb-2">Value 1 Description</label>
                        <textarea name="about_core_1_desc" rows="3"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900 text-xs">{{ $settings['about_core_1_desc'] ?? 'Every piece is crafted meticulously with premium materials to ensure durability and lasting beauty.' }}</textarea>
                    </div>
                    
                    <!-- Value 2 -->
                    <div class="bg-gray-50 p-4 border border-gray-200 rounded">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Value 2 Title</label>
                        <input type="text" name="about_core_2_title" value="{{ $settings['about_core_2_title'] ?? 'Global Appeal' }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900 mb-3 text-sm">
                        
                        <label class="block text-gray-700 text-sm font-bold mb-2">Value 2 Description</label>
                        <textarea name="about_core_2_desc" rows="3"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900 text-xs">{{ $settings['about_core_2_desc'] ?? 'Our aesthetic transcends borders, bringing a universal sense of sophisticated style directly to you.' }}</textarea>
                    </div>

                    <!-- Value 3 -->
                    <div class="bg-gray-50 p-4 border border-gray-200 rounded">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Value 3 Title</label>
                        <input type="text" name="about_core_3_title" value="{{ $settings['about_core_3_title'] ?? 'Exceptional Service' }}"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900 mb-3 text-sm">
                        
                        <label class="block text-gray-700 text-sm font-bold mb-2">Value 3 Description</label>
                        <textarea name="about_core_3_desc" rows="3"
                            class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900 text-xs">{{ $settings['about_core_3_desc'] ?? 'We are dedicated to providing a shopping experience as refined and flawless as the products we offer.' }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end mt-8 border-t pt-6">
                <button type="submit"
                    class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-8 rounded focus:outline-none focus:shadow-outline text-lg">
                    Save All Settings
                </button>
            </div>
        </form>
    </div>
@endsection