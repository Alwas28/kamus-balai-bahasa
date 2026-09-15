<x-admin-layout title="Role & Hak Akses" subtitle="Atur peran dan izin fitur.aksi untuk setiap peran">
    <div class="flex items-center justify-end mb-5">
        @can('role.tambah')
            <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center justify-center gap-2 bg-teal-700 hover:bg-teal-800 text-white text-sm font-semibold px-5 py-2.5 rounded-full transition shadow-sm shrink-0">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                Tambah Role
            </a>
        @endcan
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach ($roles as $role)
            <div class="bg-white rounded-2xl ring-1 ring-sand-200 p-6 flex flex-col">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h3 class="font-display font-semibold text-lg text-teal-900">{{ $role->name }}</h3>
                        <p class="text-xs text-ink/50 mt-1">{{ $role->description ?? 'Tidak ada deskripsi.' }}</p>
                    </div>
                    <span class="shrink-0 text-[11px] font-semibold uppercase tracking-wide bg-gold-500/15 text-gold-600 px-2.5 py-1 rounded-full">{{ $role->slug }}</span>
                </div>

                <div class="flex items-center gap-4 mt-4 text-xs text-ink/60">
                    <span>{{ $role->permissions_count }} hak akses</span>
                    <span>&middot;</span>
                    <span>{{ $role->users_count }} pengguna</span>
                </div>

                <div class="flex items-center gap-2 mt-5 pt-5 border-t border-sand-100">
                    @can('role.edit')
                        <a href="{{ route('admin.roles.edit', $role) }}" class="text-xs font-semibold text-teal-700 hover:text-teal-900 px-3 py-1.5 rounded-full hover:bg-teal-50 transition">Ubah</a>
                    @endcan
                    @can('role.delete')
                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" onsubmit="return confirm('Hapus role ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-semibold text-konawe-600 px-3 py-1.5 rounded-full hover:bg-konawe-500/10 transition">Hapus</button>
                        </form>
                    @endcan
                </div>
            </div>
        @endforeach
    </div>
</x-admin-layout>
