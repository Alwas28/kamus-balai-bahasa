<x-admin-layout :title="$category->exists ? 'Ubah Kategori' : 'Tambah Kategori'" subtitle="Kelompok kosakata dalam kamus bergambar">
    <div class="max-w-xl bg-white rounded-2xl ring-1 ring-sand-200 p-6 sm:p-8">
        <form method="POST" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
            @csrf
            @if ($category->exists) @method('PUT') @endif

            <div>
                <x-input-label for="name" value="Nama Kategori" />
                <x-text-input id="name" name="name" type="text" class="block mt-1.5 w-full" :value="old('name', $category->name)" required autofocus placeholder="mis. Buah-Buahan" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="name_tolaki" value="Nama Tolaki (opsional)" />
                <x-text-input id="name_tolaki" name="name_tolaki" type="text" class="block mt-1.5 w-full" :value="old('name_tolaki', $category->name_tolaki)" placeholder="mis. Wuahako" />
                <x-input-error :messages="$errors->get('name_tolaki')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="order" value="Urutan Tampil" />
                <x-text-input id="order" name="order" type="number" min="0" class="block mt-1.5 w-full" :value="old('order', $category->order ?? 0)" />
                <x-input-error :messages="$errors->get('order')" class="mt-2" />
            </div>

            <div class="flex items-center gap-3 mt-8">
                <x-primary-button>{{ $category->exists ? 'Simpan Perubahan' : 'Tambah Kategori' }}</x-primary-button>
                <a href="{{ route('admin.categories.index') }}" class="text-sm font-semibold text-ink/60 hover:text-ink">Batal</a>
            </div>
        </form>
    </div>
</x-admin-layout>
