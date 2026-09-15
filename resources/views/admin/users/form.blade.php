<x-admin-layout :title="$user->exists ? 'Ubah Pengguna' : 'Tambah Pengguna'" subtitle="Kelola akun dan role pengguna aplikasi">
    <div class="max-w-xl bg-white rounded-2xl ring-1 ring-sand-200 p-6 sm:p-8">
        <form method="POST" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}">
            @csrf
            @if ($user->exists) @method('PUT') @endif

            <div>
                <x-input-label for="name" value="Nama Lengkap" />
                <x-text-input id="name" name="name" type="text" class="block mt-1.5 w-full" :value="old('name', $user->name)" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" name="email" type="email" class="block mt-1.5 w-full" :value="old('email', $user->email)" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="role_id" value="Role" />
                <select id="role_id" name="role_id" class="block mt-1.5 w-full border-2 border-sand-200 focus:border-teal-500 focus:ring-teal-500 rounded-xl shadow-sm text-ink">
                    <option value="">Tanpa role</option>
                    @foreach ($roles as $id => $name)
                        <option value="{{ $id }}" @selected(old('role_id', $user->role_id) == $id)>{{ $name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="$user->exists ? 'Kata Sandi Baru (opsional)' : 'Kata Sandi'" />
                <x-text-input id="password" name="password" type="password" class="block mt-1.5 w-full" :required="! $user->exists" placeholder="{{ $user->exists ? 'Biarkan kosong jika tidak diubah' : '••••••••' }}" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi" />
                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="block mt-1.5 w-full" :required="! $user->exists" />
            </div>

            <div class="flex items-center gap-3 mt-8">
                <x-primary-button>{{ $user->exists ? 'Simpan Perubahan' : 'Tambah Pengguna' }}</x-primary-button>
                <a href="{{ route('admin.users.index') }}" class="text-sm font-semibold text-ink/60 hover:text-ink">Batal</a>
            </div>
        </form>
    </div>
</x-admin-layout>
