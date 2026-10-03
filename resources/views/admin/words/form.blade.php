<x-admin-layout :title="$word->exists ? 'Ubah Kosakata' : 'Tambah Kosakata'" subtitle="Kelola entri kata Indonesia, Konawe, dan Mekongga">
    <div class="max-w-xl bg-white rounded-2xl ring-1 ring-sand-200 p-6 sm:p-8">
        <form method="POST" action="{{ $word->exists ? route('admin.words.update', $word) : route('admin.words.store') }}" enctype="multipart/form-data">
            @csrf
            @if ($word->exists) @method('PUT') @endif

            <div>
                <x-input-label for="category_id" value="Kategori" />
                <select id="category_id" name="category_id" required class="block mt-1.5 w-full border-2 border-sand-200 focus:border-teal-500 focus:ring-teal-500 rounded-xl shadow-sm text-ink">
                    <option value="">Pilih kategori&hellip;</option>
                    @foreach ($categories as $id => $name)
                        <option value="{{ $id }}" @selected(old('category_id', $word->category_id) == $id)>{{ $name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="word_id" value="Bahasa Indonesia" />
                <x-text-input id="word_id" name="word_id" type="text" class="block mt-1.5 w-full" :value="old('word_id', $word->word_id)" required autofocus placeholder="mis. rumah" />
                <x-input-error :messages="$errors->get('word_id')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="word_konawe" value="Dialek Konawe" />
                <x-text-input id="word_konawe" name="word_konawe" type="text" class="block mt-1.5 w-full" :value="old('word_konawe', $word->word_konawe)" placeholder="mis. laika" />
                <x-input-error :messages="$errors->get('word_konawe')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="word_mekongga" value="Dialek Mekongga" />
                <x-text-input id="word_mekongga" name="word_mekongga" type="text" class="block mt-1.5 w-full" :value="old('word_mekongga', $word->word_mekongga)" placeholder="mis. laika" />
                <x-input-error :messages="$errors->get('word_mekongga')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="order" value="Urutan Tampil" />
                <x-text-input id="order" name="order" type="number" min="0" class="block mt-1.5 w-full" :value="old('order', $word->order ?? 0)" />
                <x-input-error :messages="$errors->get('order')" class="mt-2" />
            </div>

            {{-- Gambar --}}
            <div class="mt-6 pt-6 border-t border-sand-100">
                <x-input-label for="image" value="Gambar Kosakata" />
                <p class="text-xs text-ink/50 mt-1 mb-3">Ilustrasi untuk kamus bergambar. Format JPG/PNG/WEBP, maks. 2MB.</p>

                @if ($word->exists && $word->image_path)
                    <div class="flex items-center gap-3 mb-3 bg-sand-50 ring-1 ring-sand-200 rounded-xl p-3">
                        <img src="{{ $word->imageUrl() }}" alt="{{ $word->word_id }}" class="w-16 h-16 rounded-lg object-cover ring-1 ring-sand-200 shrink-0">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-ink truncate">Gambar saat ini</p>
                            <label class="inline-flex items-center gap-2 text-xs text-konawe-600 mt-1">
                                <input type="checkbox" name="remove_image" value="1" class="rounded border-sand-300 text-konawe-500 focus:ring-konawe-500">
                                Hapus gambar ini
                            </label>
                        </div>
                    </div>
                @endif

                <input id="image" name="image" type="file" accept="image/*"
                    class="block w-full text-sm text-ink file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 border-2 border-sand-200 rounded-xl focus:border-teal-500 focus:ring-teal-500">
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>

            {{-- Audio --}}
            <div class="mt-6 pt-6 border-t border-sand-100"
                x-data="{
                    enabled: '{{ old('audio_enabled', ($word->audio_enabled ?? true) ? '1' : '0') }}',
                    source: '{{ old('audio_source', $word->audio_source ?? 'auto') }}'
                }">
                <x-input-label value="Audio Pelafalan" />
                <p class="text-xs text-ink/50 mt-1 mb-3">Tentukan apakah audio pelafalan ditampilkan untuk kata ini.</p>

                <div class="grid sm:grid-cols-2 gap-3">
                    <label class="flex items-start gap-3 rounded-xl border-2 p-3.5 cursor-pointer transition"
                        :class="enabled === '1' ? 'border-teal-500 bg-teal-50/60' : 'border-sand-200 hover:border-sand-300'">
                        <input type="radio" name="audio_enabled" value="1" x-model="enabled" class="mt-0.5 text-teal-600 focus:ring-teal-500">
                        <span>
                            <span class="block text-sm font-semibold text-ink">Tampilkan</span>
                            <span class="block text-xs text-ink/50 mt-0.5">Tombol dengarkan pelafalan muncul di kamus.</span>
                        </span>
                    </label>
                    <label class="flex items-start gap-3 rounded-xl border-2 p-3.5 cursor-pointer transition"
                        :class="enabled === '0' ? 'border-teal-500 bg-teal-50/60' : 'border-sand-200 hover:border-sand-300'">
                        <input type="radio" name="audio_enabled" value="0" x-model="enabled" class="mt-0.5 text-teal-600 focus:ring-teal-500">
                        <span>
                            <span class="block text-sm font-semibold text-ink">Jangan Tampilkan</span>
                            <span class="block text-xs text-ink/50 mt-0.5">Kata ini tidak memiliki audio pelafalan.</span>
                        </span>
                    </label>
                </div>
                <x-input-error :messages="$errors->get('audio_enabled')" class="mt-2" />

                <div x-show="enabled === '1'" x-cloak class="mt-5 pt-5 border-t border-sand-100">
                    <x-input-label value="Sumber Audio" />
                    <p class="text-xs text-ink/50 mt-1 mb-3">Pilih sumber suara pelafalan kata ini.</p>

                    <div class="grid sm:grid-cols-2 gap-3">
                        <label class="flex items-start gap-3 rounded-xl border-2 p-3.5 cursor-pointer transition"
                            :class="source === 'auto' ? 'border-teal-500 bg-teal-50/60' : 'border-sand-200 hover:border-sand-300'">
                            <input type="radio" name="audio_source" value="auto" x-model="source" class="mt-0.5 text-teal-600 focus:ring-teal-500">
                            <span>
                                <span class="block text-sm font-semibold text-ink">Audio Otomatis</span>
                                <span class="block text-xs text-ink/50 mt-0.5">Dibacakan otomatis oleh perangkat (text-to-speech).</span>
                            </span>
                        </label>
                        <label class="flex items-start gap-3 rounded-xl border-2 p-3.5 cursor-pointer transition"
                            :class="source === 'local' ? 'border-teal-500 bg-teal-50/60' : 'border-sand-200 hover:border-sand-300'">
                            <input type="radio" name="audio_source" value="local" x-model="source" class="mt-0.5 text-teal-600 focus:ring-teal-500">
                            <span>
                                <span class="block text-sm font-semibold text-ink">Audio Lokal</span>
                                <span class="block text-xs text-ink/50 mt-0.5">Gunakan berkas rekaman suara yang diunggah.</span>
                            </span>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('audio_source')" class="mt-2" />

                    {{-- Otomatis: pilihan jenis suara --}}
                    <div x-show="source === 'auto'" x-cloak class="mt-4">
                        <x-input-label value="Jenis Suara" />
                        <div class="flex flex-wrap gap-3 mt-1.5">
                            <label class="inline-flex items-center gap-2 text-sm text-ink bg-sand-50 ring-1 ring-sand-200 rounded-full px-4 py-2 cursor-pointer">
                                <input type="radio" name="audio_voice" value="male"
                                    @checked(old('audio_voice', $word->audio_voice ?? 'male') === 'male')
                                    class="text-teal-600 focus:ring-teal-500">
                                Laki-laki
                            </label>
                            <label class="inline-flex items-center gap-2 text-sm text-ink bg-sand-50 ring-1 ring-sand-200 rounded-full px-4 py-2 cursor-pointer">
                                <input type="radio" name="audio_voice" value="female"
                                    @checked(old('audio_voice', $word->audio_voice ?? 'male') === 'female')
                                    class="text-teal-600 focus:ring-teal-500">
                                Perempuan
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('audio_voice')" class="mt-2" />
                    </div>

                    {{-- Lokal: unggah berkas --}}
                    <div x-show="source === 'local'" x-cloak class="mt-4">
                        @if ($word->exists && $word->audio_source === 'local' && $word->audio_path)
                            <div class="flex items-center gap-3 mb-3 bg-sand-50 ring-1 ring-sand-200 rounded-xl p-3">
                                <audio controls src="{{ '/storage/'.$word->audio_path }}" class="h-9 flex-1 min-w-0"></audio>
                                <label class="inline-flex items-center gap-2 text-xs text-konawe-600 shrink-0">
                                    <input type="checkbox" name="remove_audio" value="1" class="rounded border-sand-300 text-konawe-500 focus:ring-konawe-500">
                                    Hapus
                                </label>
                            </div>
                        @endif

                        <input id="audio" name="audio" type="file" accept="audio/*"
                            class="block w-full text-sm text-ink file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 border-2 border-sand-200 rounded-xl focus:border-teal-500 focus:ring-teal-500">
                        <p class="text-xs text-ink/50 mt-1.5">Format MP3/WAV/OGG/M4A, maks. 5MB.</p>
                        <x-input-error :messages="$errors->get('audio')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-8">
                <x-primary-button>{{ $word->exists ? 'Simpan Perubahan' : 'Tambah Kata' }}</x-primary-button>
                <a href="{{ route('admin.words.index') }}" class="text-sm font-semibold text-ink/60 hover:text-ink">Batal</a>
            </div>
        </form>
    </div>
</x-admin-layout>
