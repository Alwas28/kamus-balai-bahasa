@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-2 border-sand-200 bg-white focus:border-teal-500 focus:ring-teal-500 rounded-xl shadow-sm text-ink placeholder:text-ink/35']) }}>
