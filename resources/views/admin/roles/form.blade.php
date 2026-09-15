<x-admin-layout :title="$role->exists ? 'Ubah Role' : 'Tambah Role'" subtitle="Atur peran dan izin fitur.aksi untuk setiap peran">
    <div class="max-w-2xl bg-white rounded-2xl ring-1 ring-sand-200 p-6 sm:p-8">
        <form method="POST" action="{{ $role->exists ? route('admin.roles.update', $role) : route('admin.roles.store') }}">
            @csrf
            @if ($role->exists) @method('PUT') @endif

            <div>
                <x-input-label for="name" value="Nama Role" />
                <x-text-input id="name" name="name" type="text" class="block mt-1.5 w-full" :value="old('name', $role->name)" required autofocus placeholder="mis. Editor" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="description" value="Deskripsi (opsional)" />
                <x-text-input id="description" name="description" type="text" class="block mt-1.5 w-full" :value="old('description', $role->description)" placeholder="mis. Mengelola kategori dan kosakata" />
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-input-label value="Hak Akses (fitur.aksi)" />
                <p class="text-xs text-ink/50 mt-1 mb-3">Centang izin yang dimiliki role ini. Pola: <code class="bg-sand-100 px-1.5 py-0.5 rounded">fitur.aksi</code>, mis. <code class="bg-sand-100 px-1.5 py-0.5 rounded">kata.edit</code>.</p>

                <div class="space-y-4">
                    @foreach ($permissions as $feature => $items)
                        <div class="border border-sand-200 rounded-xl p-4">
                            <p class="text-xs font-bold uppercase tracking-wide text-teal-700 mb-2.5">{{ $feature }}</p>
                            <div class="flex flex-wrap gap-x-6 gap-y-2">
                                @foreach ($items as $permission)
                                    <label class="inline-flex items-center gap-2 text-sm text-ink">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                            class="rounded border-sand-300 text-teal-600 focus:ring-teal-500"
                                            @checked(in_array($permission->id, old('permissions', $assigned)))>
                                        {{ $permission->slug }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-3 mt-8">
                <x-primary-button>{{ $role->exists ? 'Simpan Perubahan' : 'Tambah Role' }}</x-primary-button>
                <a href="{{ route('admin.roles.index') }}" class="text-sm font-semibold text-ink/60 hover:text-ink">Batal</a>
            </div>
        </form>
    </div>
</x-admin-layout>
