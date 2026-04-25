@props(['user', 'size' => 'md'])

@php
    $sizes = [
        'sm'  => 'w-10 h-10 text-sm',
        'md'  => 'w-16 h-16 text-base',
        'lg'  => 'w-24 h-24 text-xl',
        'xl'  => 'w-32 h-32 text-2xl',
    ];
    $cls = $sizes[$size] ?? $sizes['md'];
    $initials = collect(explode(' ', $user->name))->map(fn($w) => strtoupper($w[0]))->take(2)->join('');
@endphp

@if($user->photo)
    <img src="{{ asset('storage/' . $user->photo) }}"
         alt="Photo de {{ $user->name }}"
         class="{{ $cls }} rounded-full object-cover border-2 border-blue-100 shadow-sm">
@else
    <div class="{{ $cls }} rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center border-2 border-blue-200 shadow-sm select-none">
        {{ $initials }}
    </div>
@endif
