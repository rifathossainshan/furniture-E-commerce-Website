@php
    $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
@endphp

@if(isset($settings['site_logo']))
    <img src="{{ asset($settings['site_logo']) }}" alt="Logo" {{ $attributes->merge(['class' => 'h-9 w-auto']) }}>
@else
    <span {{ $attributes->merge(['class' => 'font-bold text-xl text-gray-800 tracking-wider']) }}>{{ $settings['site_name'] ?? 'Musfiq' }}</span>
@endif
