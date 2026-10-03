<x-admin-layout title="Kosakata" subtitle="Kelola entri kata Indonesia, Konawe, dan Mekongga">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
        <form method="GET" class="flex flex-col sm:flex-row gap-3 flex-1">
            <div class="flex items-center gap-2 bg-white border-2 border-sand-200 focus-within:border-teal-500 rounded-xl px-3 py-2 transition max-w-sm">
                <svg class="w-[18px] h-[18px] text-teal-600 shrink-0" viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kata…" class="flex-1 bg-transparent outline-none text-sm border-0 p-0 focus:ring-0">
            </div>
            <select name="category_id" onchange="this.form.submit()" class="border-2 border-sand-200 focus:border-teal-500 rounded-xl text-sm text-ink py-2">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $id => $name)
                    <option value="{{ $id }}" @selected(request('category_id') == $id)>{{ $name }}</option>
                @endforeach
            </select>
        </form>

        @can('kata.tambah')
            <a href="{{ route('admin.words.create') }}" class="inline-flex items-center justify-center gap-2 bg-teal-700 hover:bg-teal-800 text-white text-sm font-semibold px-5 py-2.5 rounded-full transition shadow-sm shrink-0">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                Tambah Kata
            </a>
        @endcan
    </div>

    <div class="bg-white rounded-2xl ring-1 ring-sand-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] text-sm">
                <thead class="bg-sand-50 text-ink/50 text-xs uppercase tracking-wide">
                    <tr>
                        <th class="text-left font-semibold px-6 py-3">Gambar</th>
                        <th class="text-left font-semibold px-6 py-3">Bahasa Indonesia</th>
                        <th class="text-left font-semibold px-6 py-3">Konawe</th>
                        <th class="text-left font-semibold px-6 py-3">Mekongga</th>
                        <th class="text-left font-semibold px-6 py-3">Kategori</th>
                        <th class="text-left font-semibold px-6 py-3">Audio</th>
                        <th class="text-right font-semibold px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-sand-100">
                    @forelse ($words as $word)
                        <tr>
                            <td class="px-6 py-3">
                                @if ($word->image_path)
                                    <img src="{{ $word->imageUrl() }}" alt="{{ $word->word_id }}" class="w-10 h-10 rounded-lg object-cover ring-1 ring-sand-200">
                                @else
                                    <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-sand-100 text-ink/30">
                                        <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><circle cx="8.5" cy="9.5" r="1.5" stroke="currentColor" stroke-width="1.6"/><path d="M21 15l-5-5-9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5 font-semibold text-ink">{{ $word->word_id }}</td>
                            <td class="px-6 py-3.5 text-konawe-600 font-medium">{{ $word->word_konawe ?? '—' }}</td>
                            <td class="px-6 py-3.5 text-mekongga-600 font-medium">{{ $word->word_mekongga ?? '—' }}</td>
                            <td class="px-6 py-3.5 text-ink/60">{{ $word->category?->name }}</td>
                            <td class="px-6 py-3.5">
                                @if (! $word->audio_enabled)
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold uppercase tracking-wide bg-konawe-500/10 text-konawe-600 px-2.5 py-1 rounded-full">Nonaktif</span>
                                @elseif ($word->audio_source === 'local' && $word->audio_path)
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold uppercase tracking-wide bg-teal-50 text-teal-700 px-2.5 py-1 rounded-full">Lokal</span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold uppercase tracking-wide bg-sand-100 text-ink/50 px-2.5 py-1 rounded-full">
                                        Otomatis &middot; {{ $word->audio_voice === 'female' ? 'Perempuan' : 'Laki-laki' }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5">
                                <div class="flex items-center justify-end gap-2">
                                    @can('kata.edit')
                                        <a href="{{ route('admin.words.edit', $word) }}" class="text-xs font-semibold text-teal-700 hover:text-teal-900 px-3 py-1.5 rounded-full hover:bg-teal-50 transition">Ubah</a>
                                    @endcan
                                    @can('kata.delete')
                                        <form method="POST" action="{{ route('admin.words.destroy', $word) }}" onsubmit="return confirm('Hapus kata ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-semibold text-konawe-600 px-3 py-1.5 rounded-full hover:bg-konawe-500/10 transition">Hapus</button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-ink/50">Belum ada kosakata.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5">
        {{ $words->links() }}
    </div>
</x-admin-layout>
