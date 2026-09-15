<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-xl text-teal-900 leading-tight">
            {{ __('Dasbor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm ring-1 ring-sand-200 sm:rounded-2xl">
                <div class="p-8">
                    <p class="text-ink/70">Selamat datang, <span class="font-semibold text-teal-800">{{ auth()->user()->name }}</span>! Anda masuk sebagai <span class="font-semibold text-teal-800">{{ auth()->user()->role?->name ?? 'Pengguna' }}</span>.</p>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('home') }}#cari" class="inline-flex items-center gap-2 bg-teal-700 hover:bg-teal-800 text-white text-sm font-semibold px-5 py-2.5 rounded-full transition">
                            Jelajahi Kamus
                        </a>
                        @can('dashboard.read')
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 bg-sand-100 hover:bg-sand-200 text-teal-800 text-sm font-semibold px-5 py-2.5 rounded-full transition">
                                Buka Panel Admin
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
