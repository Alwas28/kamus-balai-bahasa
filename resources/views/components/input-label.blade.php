@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-teal-900']) }}>
    {{ $value ?? $slot }}
</label>
