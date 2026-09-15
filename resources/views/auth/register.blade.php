<x-guest-layout>
    <div class="text-center mb-6">
        <span class="inline-flex items-center gap-2 bg-gold-500/15 text-gold-600 text-xs font-semibold tracking-wide uppercase px-3 py-1.5 rounded-full">
            Daftar
        </span>
        <h1 class="font-display text-2xl font-semibold text-teal-900 mt-3">Buat akun baru</h1>
        <p class="text-sm text-ink/60 mt-1">Gabung dan mulai pelajari kosakata Tolaki.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block mt-1.5 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama kamu" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Kata Sandi')" />

            <x-text-input id="password" class="block mt-1.5 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />

            <x-text-input id="password_confirmation" class="block mt-1.5 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center mt-6">
            {{ __('Daftar') }}
        </x-primary-button>

        <p class="text-center text-sm text-ink/60 mt-5">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-teal-700 hover:text-teal-900 font-semibold">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>
