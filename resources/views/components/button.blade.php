@props(['variant' => 'primary', 'type' => 'button'])

@php
    $baseClasses = 'inline-flex items-center justify-center rounded-xl px-6 py-3 text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none';
    
    $variants = [
        'primary' => 'bg-[var(--color-primary)] text-white hover:bg-blue-600 focus:ring-blue-500',
        'secondary' => 'bg-white border text-[var(--color-primary)] hover:bg-gray-50 focus:ring-blue-500',
        'success' => 'bg-[var(--color-secondary)] text-white hover:bg-emerald-600 focus:ring-emerald-500',
        'danger' => 'bg-[var(--color-danger)] text-white hover:bg-red-600 focus:ring-red-500',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

<button {{ $attributes->merge(['type' => $type, 'class' => $classes]) }}>
    {{ $slot }}
</button>
