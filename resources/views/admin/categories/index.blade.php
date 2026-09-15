<x-admin-layout title="Kategori" subtitle="Kelompok kosakata dalam kamus bergambar">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
        <form method="GET" class="flex-1 max-w-sm">
            <div class="flex items-center gap-2 bg-white border-2 border-sand-200 focus-within:border-teal-500 rounded-xl px-3 py-2 transition">
                <svg class="w-[18px] h-[18px] text-teal-600 shrink-0" viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kategori…" class="flex-1 bg-transparent outline-none text-sm border-0 p-0 focus:ring-0">
            </div>
        </form>

        @can('kategori.tambah')
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center justify-center gap-2 bg-teal-700 hover:bg-teal-800 text-white text-sm font-semibold px-5 py-2.5 rounded-full transition shadow-sm shrink-0">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                Tambah Kategori
            </a>
        @endcan
    </div>

    <div class="bg-white rounded-2xl ring-1 ring-sand-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[560px] text-sm">
                <thead class="bg-sand-50 text-ink/50 text-xs uppercase tracking-wide">
                    <tr>
                        <th class="text-left font-semibold px-6 py-3">Nama</th>
                        <th class="text-left font-semibold px-6 py-3">Nama Tolaki</th>
                        <th class="text-left font-semibold px-6 py-3">Jumlah Kata</th>
                        <th class="text-right font-semibold px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-sand-100">
                    @forelse ($categories as $category)
                        <tr>
                            <td class="px-6 py-3.5 font-semibold text-ink">{{ $category->name }}</td>
                            <td class="px-6 py-3.5 text-ink/60">{{ $category->name_tolaki ?? '—' }}</td>
                            <td class="px-6 py-3.5 text-ink/60">{{ $category->words_count }}</td>
                            <td class="px-6 py-3.5">
                                <div class="flex items-center justify-end gap-2">
                                    @can('kategori.edit')
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-xs font-semibold text-teal-700 hover:text-teal-900 px-3 py-1.5 rounded-full hover:bg-teal-50 transition">Ubah</a>
                                    @endcan
                                    @can('kategori.delete')
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini beserta seluruh kosakatanya?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-semibold text-konawe-600 hover:text-konawe-600 px-3 py-1.5 rounded-full hover:bg-konawe-500/10 transition">Hapus</button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-ink/50">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5">
        {{ $categories->links() }}
    </div>
</x-admin-layout>
