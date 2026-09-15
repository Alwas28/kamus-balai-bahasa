<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-konawe-500 border border-transparent rounded-full font-semibold text-sm text-white hover:bg-konawe-600 active:bg-konawe-600 focus:outline-none focus:ring-2 focus:ring-konawe-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
