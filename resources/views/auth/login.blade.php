<x-guest-layout>
    <div class="text-center mb-6">
        <span class="inline-flex items-center gap-2 bg-teal-50 text-teal-700 text-xs font-semibold tracking-wide uppercase px-3 py-1.5 rounded-full">
            Masuk
        </span>
        <h1 class="font-display text-2xl font-semibold text-teal-900 mt-3">Selamat datang kembali</h1>
        <p class="text-sm text-ink/60 mt-1">Masuk untuk melanjutkan menjelajah kamus.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Kata Sandi')" />

            <x-text-input id="password" class="block mt-1.5 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-sand-300 text-teal-600 shadow-sm focus:ring-teal-500" name="remember">
                <span class="ms-2 text-sm text-ink/70">{{ __('Ingat saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-teal-700 hover:text-teal-900 font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500" href="{{ route('password.request') }}">
                    {{ __('Lupa kata sandi?') }}
                </a>
            @endif
        </div>

        <x-primary-button class="w-full justify-center mt-6">
            {{ __('Masuk') }}
        </x-primary-button>

        <p class="text-center text-sm text-ink/60 mt-5">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-teal-700 hover:text-teal-900 font-semibold">Daftar sekarang</a>
        </p>
    </form>
</x-guest-layout>
