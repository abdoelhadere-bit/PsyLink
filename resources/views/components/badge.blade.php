@props(['variant' => 'pending'])

@php
    $baseClasses = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium';
    
    $variants = [
        'pending' => 'bg-orange-100 text-orange-800',
        'accepted' => 'bg-blue-100 text-blue-800',
        'paid' => 'bg-green-100 text-green-800',
        'completed' => 'bg-gray-100 text-gray-800',
        'cancelled' => 'bg-red-100 text-red-800',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['pending']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
