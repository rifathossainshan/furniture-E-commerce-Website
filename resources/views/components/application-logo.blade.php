@php
    $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
@endphp

@if(isset($settings['site_logo']))
    <img src="{{ asset($settings['site_logo']) }}" alt="Logo" style="height: 64px; width: auto; object-fit: contain;">
@else
    <span {{ $attributes->merge(['class' => 'font-bold text-xl text-gray-800 tracking-wider']) }}>{{ $settings['site_name'] ?? 'Musfiq' }}</span>
@endif
