@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-teal-50 text-teal-800 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-4 py-2 rounded-full text-sm font-medium text-ink/60 hover:bg-sand-100 hover:text-ink transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
