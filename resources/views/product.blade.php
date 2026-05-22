@extends('layouts.store')

@section('title', $product->meta_title ?: $product->name . ' - ' . ($settings['site_name'] ?? config('app.name', 'Musfiq')))

@section('meta')
    @if($product->meta_description)
        <meta name="description" content="{{ $product->meta_description }}">
    @endif
    @if($product->meta_keywords)
        <meta name="keywords" content="{{ $product->meta_keywords }}">
    @endif
    
    <!-- Open Graph for Social Media -->
    <meta property="og:title" content="{{ $product->meta_title ?: $product->name }}">
    @if($product->meta_description)
        <meta property="og:description" content="{{ $product->meta_description }}">
    @endif
    <meta property="og:type" content="product">
    <meta property="og:url" content="{{ url()->current() }}">
    @if($product->image)
        <meta property="og:image" content="{{ asset($product->image) }}">
    @endif
@endsection

@section('content')
    <script>
    fbq('track', 'ViewContent', {
      content_name: '{{ addslashes($product->name) }}',
      content_ids: ['{{ $product->id }}'],
      content_type: 'product',
      value: {{ $product->price }},
      currency: 'BDT'
    });
    </script>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative mb-8">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Product Top Section -->
        <div class="flex flex-col md:flex-row gap-12">

            <!-- Left: Image Gallery -->
            @php
                $allImages = [];
                if ($product->image) {
                    $allImages[] = asset($product->image);
                }
                if (is_array($product->images)) {
                    foreach($product->images as $img) {
                        $allImages[] = asset($img);
                    }
                }
            @endphp
            <style>
                .no-scrollbar::-webkit-scrollbar {
                    display: none;
                }
                .no-scrollbar {
                    -ms-overflow-style: none;
                    scrollbar-width: none;
                }
            </style>
            <div class="w-full md:w-1/2" x-data="{ currentSlide: 0, images: {{ json_encode($allImages, JSON_UNESCAPED_SLASHES) }} }">
                <!-- Main Image -->
                <div class="w-full overflow-hidden bg-stone-100 mb-4 shadow-sm border border-gray-100 relative group">
                    <template x-if="images.length > 0">
                        <img :src="images[currentSlide]" class="w-full aspect-square object-cover object-center transition duration-500">
                    </template>
                    <template x-if="images.length === 0">
                        <div class="w-full aspect-square flex flex-col justify-center items-center text-gray-400">
                            <svg class="h-16 w-16 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span>No Image Available</span>
                        </div>
                    </template>
                </div>
                
                <!-- Thumbnails Gallery & Arrows -->
                <template x-if="images.length > 1">
                    <div class="flex items-center justify-center gap-2 mt-4">
                        <!-- Prev Arrow -->
                        <button @click="currentSlide = currentSlide > 0 ? currentSlide - 1 : images.length - 1" class="p-2 text-gray-400 hover:text-gray-900 focus:outline-none flex-shrink-0 transition">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        
                        <!-- Thumbnails -->
                        <div class="flex overflow-x-auto snap-x gap-3 py-1 no-scrollbar justify-center items-center px-2">
                            <template x-for="(img, index) in images" :key="index">
                                <button @click="currentSlide = index" 
                                    :class="{'border-black': currentSlide === index, 'border-transparent': currentSlide !== index}" 
                                    class="flex-shrink-0 w-20 h-20 md:w-24 md:h-24 overflow-hidden border-2 transition focus:outline-none snap-start bg-white">
                                    <img :src="img" class="w-full h-full object-cover hover:opacity-80 transition p-0.5">
                                </button>
                            </template>
                        </div>

                        <!-- Next Arrow -->
                        <button @click="currentSlide = currentSlide < images.length - 1 ? currentSlide + 1 : 0" class="p-2 text-gray-400 hover:text-gray-900 focus:outline-none flex-shrink-0 transition">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </template>
            </div>

            <!-- Right: Product Info -->
            @php
                // Build attribute map safely without arrow functions
                $attrMap = [];
                if ($product->attributes && $product->attributes->count() > 0) {
                    foreach ($product->attributes as $attr) {
                        $vals = array_filter(array_map('trim', explode(',', $attr->value)));
                        foreach ($vals as $v) {
                            $attrMap[$attr->name][] = $v;
                        }
                    }
                    // Deduplicate values per name
                    foreach ($attrMap as $k => $v) {
                        $attrMap[$k] = array_values(array_unique($v));
                    }
                }
            @endphp
            <div class="w-full md:w-1/2 flex flex-col pt-4 md:pt-10"
                x-data="productOptions({{ json_encode($attrMap) }})">
                <div class="text-[10px] text-gray-500 uppercase tracking-widest mb-2">
                    {{ $product->category->name ?? 'MUSFIQ' }}</div>
                <h1 class="text-3xl md:text-4xl font-serif text-gray-900 leading-tight mb-4">{{ $product->name }}</h1>

                <p class="text-2xl text-gray-900 font-bold mb-6">৳{{ number_format($product->price, 2) }}</p>

                <div class="prose prose-sm text-gray-600 mb-8 max-w-none">
                    <p>{!! nl2br(e($product->description)) !!}</p>
                </div>

                @if(!empty($attrMap))
                <div class="mb-8 border-t border-gray-200 pt-6">
                    <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-4">Specifications</p>
                    <div class="space-y-5">
                        @foreach($attrMap as $attrName => $allValues)
                            <div>
                                <p class="text-sm font-bold text-gray-800 mb-2">{{ $attrName }}</p>
                                @if(count($allValues) > 1)
                                    {{-- Multiple values → show as selectable pill buttons --}}
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($allValues as $val)
                                            <button type="button"
                                                @click="selectAttr('{{ addslashes($attrName) }}', '{{ addslashes($val) }}')"
                                                :class="selectedAttrs['{{ $attrName }}'] === '{{ $val }}' ? 'bg-gray-900 text-white border-gray-900' : 'bg-white text-gray-700 border-gray-300 hover:border-gray-900'"
                                                class="px-4 py-1.5 rounded-full border text-sm font-medium transition-all duration-150 focus:outline-none">
                                                {{ $val }}
                                            </button>
                                        @endforeach
                                    </div>
                                    <p x-show="errors['{{ $attrName }}']" class="text-red-500 text-xs mt-1">Please select a {{ $attrName }}</p>
                                @else
                                    {{-- Single value → just show as text --}}
                                    <span class="text-sm font-medium text-gray-900">{{ $allValues[0] ?? '' }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="mb-8 border-t border-gray-200 pt-6">
                    <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-2">Availability</p>
                    @if($product->stock > 0)
                        <p class="text-green-600 font-medium text-sm flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            In Stock
                        </p>
                    @else
                        <p class="text-red-600 font-medium text-sm flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                                </path>
                            </svg>
                            Out of Stock
                        </p>
                    @endif
                </div>

                @php
                    $whatsapp = \App\Models\Setting::where('key', 'whatsapp')->value('value') ?? '+8801XXXXXXXXX';
                    $email = \App\Models\Setting::where('key', 'email')->value('value') ?? 'contact@example.com';
                    $btnType = $product->button_type;
                    if (empty($btnType) || $btnType === 'default') {
                        $btnType = $product->category->button_type ?? 'buy_now';
                    }
                @endphp

                @if($btnType == 'inquiry')
                    <div class="mt-auto bg-gray-50 p-6 rounded border border-gray-200">
                        <p class="text-lg font-bold text-gray-900 mb-2">Interested in this product?</p>
                        <p class="text-sm text-gray-600 mb-4">Please contact us via WhatsApp or Email for more details and to place an inquiry.</p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" target="_blank" class="flex-1 bg-green-500 text-white hover:bg-green-600 transition py-3 px-6 text-center font-bold uppercase tracking-wider rounded shadow flex justify-center items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                                WhatsApp
                            </a>
                            <a href="mailto:{{ $email }}?subject=Inquiry about {{ $product->name }}" class="flex-1 bg-gray-900 text-white hover:bg-gray-800 transition py-3 px-6 text-center font-bold uppercase tracking-wider rounded shadow flex justify-center items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                Email Us
                            </a>
                        </div>
                    </div>
                @else
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-auto flex flex-col md:flex-row gap-4" @submit.prevent="submitCartForm($event)" onsubmit="fbq('track', 'AddToCart', { content_name: '{{ addslashes($product->name) }}', content_ids: ['{{ $product->id }}'], content_type: 'product', value: {{ $product->price }}, currency: 'BDT' });">
                        @csrf
                        <input type="hidden" name="buy_now" :value="buyNow">
                        {{-- Dynamic hidden inputs for selected attributes appended by Alpine --}}
                        <template x-for="(val, key) in selectedAttrs" :key="key">
                            <input type="hidden" :name="'attr_' + key" :value="val">
                        </template>

                        @if($btnType == 'buy_now')
                            <button type="submit" @click="buyNow = 0" @disabled($product->stock <= 0)
                                class="w-full md:w-auto btn-primary text-sm font-bold uppercase tracking-wider py-4 px-8 disabled:opacity-50">
                                Add to Cart
                            </button>
                            @if($product->stock > 0)
                                <button type="submit" @click="buyNow = 1"
                                    class="w-full md:w-auto bg-white border border-[#a83279] text-[#a83279] hover:bg-[#a83279] hover:text-white transition py-4 px-8 text-sm font-bold uppercase tracking-wider rounded-[25px]">
                                    Buy Now
                                </button>
                            @endif
                        @elseif($btnType == 'inquiry_booking')
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" target="_blank" class="w-full md:w-auto bg-green-500 text-white hover:bg-green-600 transition py-4 px-8 text-center text-sm font-bold uppercase tracking-wider rounded-[25px] flex justify-center items-center gap-2">
                                Send Inquiry
                            </a>
                            @if($product->stock > 0)
                                <button type="submit" @click="buyNow = 1" name="is_booking" value="1"
                                    class="w-full md:w-auto bg-white border border-pink-700 text-pink-700 hover:bg-pink-700 hover:text-white transition py-4 px-8 text-sm font-bold uppercase tracking-wider rounded-[25px]">
                                    Booking
                                </button>
                            @endif
                        @elseif($btnType == 'inquiry_buy_now')
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" target="_blank" class="w-full md:w-auto bg-green-500 text-white hover:bg-green-600 transition py-4 px-8 text-center text-sm font-bold uppercase tracking-wider rounded-[25px] flex justify-center items-center gap-2">
                                Send Inquiry
                            </a>
                            @if($product->stock > 0)
                                <button type="submit" @click="buyNow = 1"
                                    class="w-full md:w-auto bg-white border border-pink-700 text-pink-700 hover:bg-pink-700 hover:text-white transition py-4 px-8 text-sm font-bold uppercase tracking-wider rounded-[25px]">
                                    Buy Now
                                </button>
                            @endif
                        @endif
                    </form>
                @endif

                <script>
                function productOptions(attributeMap) {
                    // attributeMap: { "Size": ["42","43","44"], "Color": ["Red","Blue"] }
                    const requiresSelection = {};
                    for (const name in attributeMap) {
                        if (attributeMap[name].length > 1) {
                            requiresSelection[name] = true;
                        }
                    }
                    return {
                        selectedAttrs: {},
                        errors: {},
                        buyNow: 0,
                        selectAttr(name, val) {
                            this.selectedAttrs[name] = val;
                            this.errors[name] = false;
                        },
                        submitCartForm(event) {
                            // Validate required selections
                            let valid = true;
                            this.errors = {};
                            for (const name in requiresSelection) {
                                if (!this.selectedAttrs[name]) {
                                    this.errors[name] = true;
                                    valid = false;
                                }
                            }
                            if (!valid) return;
                            event.target.submit();
                        }
                    };
                }
                </script>

                <div class="mt-4">
                    <form action="{{ route('wishlist.add', $product) }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center text-sm font-semibold tracking-wide transition {{ session('wishlist') && isset(session('wishlist')[$product->id]) ? 'text-red-500' : 'text-gray-500 hover:text-red-500' }}">
                            <svg class="w-5 h-5 mr-2" {{ session('wishlist') && isset(session('wishlist')[$product->id]) ? 'fill="currentColor"' : 'fill="none"' }} stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            {{ session('wishlist') && isset(session('wishlist')[$product->id]) ? 'Saved to Wishlist' : 'Add to Wishlist' }}
                        </button>
                    </form>
                </div>

                <!-- Additional Guarantees -->
                <div class="mt-8 grid grid-cols-2 gap-4 border-t border-gray-200 pt-6">
                    <div class="flex items-start text-gray-500 text-xs">
                        <svg class="h-5 w-5 mr-3 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4">
                            </path>
                        </svg>
                        <span>{{ \App\Models\Setting::where('key', 'shipping_title')->value('value') ?? 'Free Global Shipping' }}<br />{{ \App\Models\Setting::where('key', 'shipping_subtitle')->value('value') ?? 'on orders over $500' }}</span>
                    </div>
                    <div class="flex items-start text-gray-500 text-xs">
                        <svg class="h-5 w-5 mr-3 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ \App\Models\Setting::where('key', 'returns_title')->value('value') ?? '30-Day Free Returns' }}<br />{{ \App\Models\Setting::where('key', 'returns_subtitle')->value('value') ?? 'No questions asked' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Reviews Section -->
        <div class="mt-24 border-t border-gray-200 pt-16">
            <div class="mb-10">
                <h3 class="text-2xl font-serif text-gray-900 tracking-wider">Customer Reviews</h3>
            </div>
            
            <div class="flex flex-col md:flex-row gap-12">
                <!-- Review List -->
                <div class="w-full md:w-2/3">
                    @php
                        $approvedReviews = $product->reviews()->with(['user', 'images'])->where('status', 'approved')->latest()->get();
                    @endphp

                    @if(session('success_review'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative mb-6">
                            <span class="block sm:inline">{{ session('success_review') }}</span>
                        </div>
                    @endif

                    <div class="space-y-8">
                        @forelse($approvedReviews as $review)
                            <div class="bg-white border border-gray-100 p-6 shadow-sm">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <strong class="text-gray-900 text-lg">{{ $review->customer_name ?? ($review->user->name ?? 'Guest') }}</strong>
                                        <div class="flex items-center mt-1">
                                            @for($i=1; $i<=5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @endfor
                                            <span class="text-xs text-gray-500 ml-2">{{ ($review->review_date ?? $review->created_at)->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>

                                @if($review->comment)
                                    <p class="text-gray-700 text-sm mb-4">{{ $review->comment }}</p>
                                @endif

                                @if($review->images->count())
                                    <div class="flex flex-wrap gap-2 mt-4">
                                        @foreach($review->images as $img)
                                            <img src="{{ asset($img->image) }}" class="w-20 h-20 object-cover border border-gray-200">
                                        @endforeach
                                    </div>
                                @endif

                                @if($review->admin_reply)
                                    <div class="mt-6 p-4 bg-stone-50 border-l-4 border-pink-700">
                                        <div class="flex items-center mb-2">
                                            <strong class="text-sm text-gray-900 uppercase tracking-widest">{{ $review->reply_by ?? 'Admin' }}</strong>
                                            @if($review->is_verified_reply)
                                                <span class="ml-2 flex items-center text-[10px] text-green-600 font-bold uppercase tracking-widest">
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                                    Verified
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-gray-700 text-sm">{{ $review->admin_reply }}</p>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-gray-500 italic">There are no reviews for this product yet.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Review Form -->
                <div class="w-full md:w-1/3">
                    <div class="bg-stone-50 p-6 md:p-8">
                        <h4 class="text-lg font-bold text-gray-900 uppercase tracking-widest mb-6">Write a Review</h4>
                        
                            <form action="{{ route('reviews.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                @guest
                                <div class="mb-4">
                                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-widest mb-2">Your Name</label>
                                    <input type="text" name="customer_name" required placeholder="Enter your full name" class="w-full border-gray-200 focus:border-gray-900 focus:ring-0 text-gray-900 bg-white p-3">
                                </div>
                                @endguest

                                <div class="mb-4">
                                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-widest mb-2">Rating</label>
                                    <select name="rating" required class="w-full border-gray-200 focus:border-gray-900 focus:ring-0 text-gray-900 bg-white p-3">
                                        <option value="">Select rating</option>
                                        <option value="5">5 Stars - Excellent</option>
                                        <option value="4">4 Stars - Good</option>
                                        <option value="3">3 Stars - Average</option>
                                        <option value="2">2 Stars - Poor</option>
                                        <option value="1">1 Star - Terrible</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-widest mb-2">Your Review</label>
                                    <textarea name="comment" rows="4" placeholder="Share your experience..." class="w-full border-gray-200 focus:border-gray-900 focus:ring-0 text-gray-900 bg-white p-3 resize-none"></textarea>
                                </div>

                                <div class="mb-6">
                                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-widest mb-2">Add Photos (Max 3)</label>
                                    <input type="file" name="images[]" multiple accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-gray-900 file:text-white hover:file:bg-gray-800">
                                    <p class="text-[10px] text-gray-400 mt-1 uppercase">Valid formats: JPG, PNG, WEBP. Max size: 2MB.</p>
                                </div>

                                <button type="submit" class="w-full btn-primary py-4 tracking-[0.2em] text-sm font-bold uppercase shadow-sm">
                                    Submit Review
                                </button>
                            </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if(count($relatedProducts) > 0)
            <div class="mt-24">
                <div class="text-center mb-10">
                    <h3 class="text-2xl font-serif text-gray-900 tracking-wider">You May Also Like</h3>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
                    @foreach($relatedProducts as $related)
                        <div class="group relative flex flex-col overflow-hidden rounded mb-4 shadow-sm bg-white border border-gray-100 p-2">
                            <!-- Wishlist Button -->
                            <form action="{{ route('wishlist.add', $related) }}" method="POST" class="absolute top-4 right-4 z-20">
                                @csrf
                                <button type="submit" class="p-2 bg-white rounded-full shadow hover:bg-gray-50 text-gray-400 hover:text-red-500 transition-colors {{ session('wishlist') && isset(session('wishlist')[$related->id]) ? 'text-red-500' : '' }}" title="Add to Wishlist">
                                    <svg class="w-4 h-4" {{ session('wishlist') && isset(session('wishlist')[$related->id]) ? 'fill="currentColor"' : 'fill="none"' }} stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </form>

                            <a href="{{ route('product.show', $related->slug) }}" class="block w-full">
                                <div class="w-full relative overflow-hidden rounded bg-stone-100" style="padding-bottom: 125%;">
                                    @if($related->image)
                                        <img src="{{ asset($related->image) }}"
                                            class="absolute inset-0 w-full h-full object-cover object-center group-hover:scale-105 transition duration-700">
                                    @else
                                        <div class="w-full h-full bg-stone-100"></div>
                                    @endif
                                    @if($related->stock <= 0)
                                        <div class="absolute inset-0 bg-white/60 flex items-center justify-center">
                                            <span
                                                class="bg-white text-gray-900 font-bold px-3 py-1 text-xs tracking-wider uppercase border border-gray-200 shadow-sm">Out
                                                of Stock</span>
                                        </div>
                                    @endif
                                </div>
                            </a>

                            <div class="pt-4 pb-2 text-center flex-1 flex flex-col flex-grow">
                                <a href="{{ route('product.show', $related->slug) }}" class="block">
                                    <div class="text-[10px] text-gray-500 uppercase tracking-widest mb-1">
                                        {{ $related->category->name ?? 'MUSFIQ' }}</div>
                                    <h4 class="text-sm font-semibold text-gray-900 mb-1 line-clamp-2 uppercase">{{ $related->name }}</h4>
                                    <p class="text-base text-gray-900 font-bold mb-2">৳{{ number_format($related->price, 2) }}</p>
                                    <div class="text-xs text-gray-500 font-semibold mb-4 flex justify-center items-center gap-1">
                                        <span class="text-gray-500">★</span> {{ number_format($related->reviews_avg_rating ?? 0, 1) }}
                                    </div>
                                </a>
                                <div class="mt-auto">
                                    <form action="{{ route('cart.add', $related) }}" method="POST" onsubmit="fbq('track', 'AddToCart', { content_name: '{{ addslashes($related->name) }}', content_ids: ['{{ $related->id }}'], content_type: 'product', value: {{ $related->price }}, currency: 'BDT' });">
                                        @csrf
                                        <button type="submit" @disabled($related->stock <= 0)
                                            class="w-full btn-primary text-xs font-bold py-2.5 uppercase tracking-wider disabled:opacity-50 disabled:cursor-not-allowed">
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
