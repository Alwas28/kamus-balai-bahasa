<x-admin-layout title="Dasbor" subtitle="Ringkasan isi kamus dan aktivitas terbaru">
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl p-6 ring-1 ring-sand-200">
            <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center mb-3">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h10M4 18h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            </div>
            <p class="text-2xl font-display font-semibold text-teal-900">{{ $totalCategories }}</p>
            <p class="text-sm text-ink/50 mt-1">Kategori</p>
        </div>
        <div class="bg-white rounded-2xl p-6 ring-1 ring-sand-200">
            <div class="w-10 h-10 rounded-xl bg-konawe-500/10 text-konawe-600 flex items-center justify-center mb-3">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"><path d="M4 19.5A2.5 2.5 0 016.5 17H20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <p class="text-2xl font-display font-semibold text-teal-900">{{ $totalWords }}</p>
            <p class="text-sm text-ink/50 mt-1">Kosakata</p>
        </div>
        <div class="bg-white rounded-2xl p-6 ring-1 ring-sand-200">
            <div class="w-10 h-10 rounded-xl bg-mekongga-500/10 text-mekongga-600 flex items-center justify-center mb-3">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.2" stroke="currentColor" stroke-width="1.8"/><path d="M4.5 20a7.5 7.5 0 0115 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            </div>
            <p class="text-2xl font-display font-semibold text-teal-900">{{ $totalUsers }}</p>
            <p class="text-sm text-ink/50 mt-1">Pengguna</p>
        </div>
        <div class="bg-white rounded-2xl p-6 ring-1 ring-sand-200">
            <div class="w-10 h-10 rounded-xl bg-gold-500/15 text-gold-600 flex items-center justify-center mb-3">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"><path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
            </div>
            <p class="text-2xl font-display font-semibold text-teal-900">{{ $totalRoles }}</p>
            <p class="text-sm text-ink/50 mt-1">Role</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-5 mt-6">
        <div class="bg-white rounded-2xl ring-1 ring-sand-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-sand-100 flex items-center justify-between">
                <h2 class="font-display font-semibold text-teal-900">Kosakata Terbaru</h2>
                @can('kata.read')
                    <a href="{{ route('admin.words.index') }}" class="text-xs font-semibold text-teal-700 hover:text-teal-900">Lihat semua</a>
                @endcan
            </div>
            <ul class="divide-y divide-sand-100">
                @forelse ($latestWords as $word)
                    <li class="px-6 py-3.5 flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <p class="font-semibold text-ink truncate">{{ $word->word_id }}</p>
                            <p class="text-xs text-ink/50">{{ $word->category?->name }}</p>
                        </div>
                        <div class="text-right text-xs shrink-0">
                            <p class="text-konawe-600 font-semibold">{{ $word->word_konawe }}</p>
                            <p class="text-mekongga-600 font-semibold">{{ $word->word_mekongga }}</p>
                        </div>
                    </li>
                @empty
                    <li class="px-6 py-6 text-sm text-ink/50">Belum ada kosakata.</li>
                @endforelse
            </ul>
        </div>

        <div class="bg-white rounded-2xl ring-1 ring-sand-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-sand-100 flex items-center justify-between">
                <h2 class="font-display font-semibold text-teal-900">Pengguna Terbaru</h2>
                @can('pengguna.read')
                    <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-teal-700 hover:text-teal-900">Lihat semua</a>
                @endcan
            </div>
            <ul class="divide-y divide-sand-100">
                @forelse ($latestUsers as $user)
                    <li class="px-6 py-3.5 flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <p class="font-semibold text-ink truncate">{{ $user->name }}</p>
                            <p class="text-xs text-ink/50 truncate">{{ $user->email }}</p>
                        </div>
                        <span class="shrink-0 text-[11px] font-semibold uppercase tracking-wide bg-teal-50 text-teal-700 px-2.5 py-1 rounded-full">{{ $user->role?->name ?? 'Tanpa role' }}</span>
                    </li>
                @empty
                    <li class="px-6 py-6 text-sm text-ink/50">Belum ada pengguna.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-admin-layout>
