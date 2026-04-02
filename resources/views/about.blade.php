@extends('layouts.store')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-serif text-gray-900 tracking-wider mb-6">About Us</h1>
        <div class="w-24 h-1 bg-[#d4af37] mx-auto"></div>
    </div>
    
    <div class="prose prose-lg mx-auto text-gray-600 leading-relaxed text-center sm:text-left">
        @php
            $aboutUsRaw = \App\Models\Setting::where('key', 'about_us')->value('value') ?? 'Welcome to Musfiq. We redefine elegance.';
        @endphp
        
        {!! nl2br(e($aboutUsRaw)) !!}
    </div>
</div>
@endsection
