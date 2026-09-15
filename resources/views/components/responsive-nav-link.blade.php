@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-teal-500 text-start text-base font-medium text-teal-800 bg-teal-50 focus:outline-none focus:text-teal-900 focus:bg-teal-100 focus:border-teal-700 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-ink/60 hover:text-ink hover:bg-sand-100 hover:border-sand-300 focus:outline-none focus:text-ink focus:bg-sand-100 focus:border-sand-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
