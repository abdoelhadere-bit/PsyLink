@props(['noPadding' => false])

<div {{ $attributes->class([
    'bg-white' => !str_contains($attributes->get('class', ''), 'bg-'),
    'rounded-[2rem] shadow-[0_8px_40px_rgba(0,0,0,0.03)] border border-slate-100 transition-all duration-500',
    'p-0' => $noPadding,
    'p-6 sm:p-10' => !$noPadding,
])->merge() }}>
    {{ $slot }}
</div>