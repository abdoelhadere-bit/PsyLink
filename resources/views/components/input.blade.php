@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge([
    'class' => 'bg-white border text-[var(--color-text-dark)] border-[var(--color-border-light)] rounded-xl px-4 py-3 focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)] focus:ring-1 outline-none transition-shadow shadow-sm disabled:bg-gray-50 disabled:text-gray-500'
]) }}>
