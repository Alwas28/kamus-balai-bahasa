<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Word;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class WordController extends Controller
{
    public function index(Request $request): View
    {
        $words = Word::with('category')
            ->when($request->filled('q'), fn ($query) => $query->where('word_id', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->integer('category_id')))
            ->orderBy('category_id')
            ->orderBy('order')
            ->paginate(20)
            ->withQueryString();

        $categories = Category::orderBy('order')->pluck('name', 'id');

        return view('admin.words.index', compact('words', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('order')->pluck('name', 'id');

        return view('admin.words.form', ['word' => new Word, 'categories' => $categories]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data = $this->handleUploads($request, $data);

        Word::create($data);

        return redirect()->route('admin.words.index')->with('status', 'Kosakata berhasil ditambahkan.');
    }

    public function edit(Word $word): View
    {
        $categories = Category::orderBy('order')->pluck('name', 'id');

        return view('admin.words.form', compact('word', 'categories'));
    }

    public function update(Request $request, Word $word): RedirectResponse
    {
        $data = $this->validated($request, $word);
        $data = $this->handleUploads($request, $data, $word);

        $word->update($data);

        return redirect()->route('admin.words.index')->with('status', 'Kosakata berhasil diperbarui.');
    }

    public function destroy(Word $word): RedirectResponse
    {
        if ($word->image_path) {
            Storage::disk('public')->delete($word->image_path);
        }
        foreach (array_keys(Word::AUDIO_LANGUAGES) as $language) {
            if ($path = $word->audioPath($language)) {
                Storage::disk('public')->delete($path);
            }
        }

        $word->delete();

        return redirect()->route('admin.words.index')->with('status', 'Kosakata berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request, ?Word $word = null): array
    {
        $languages = implode(',', array_keys(Word::AUDIO_LANGUAGES));

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'word_id' => ['required', 'string', 'max:255'],
            'word_konawe' => ['nullable', 'string', 'max:255'],
            'word_mekongga' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
            'remove_image' => ['nullable', 'boolean'],
            'audio_enabled' => ['required', 'boolean'],
            'audio_source' => ['required', "array:{$languages}"],
            'audio_source.*' => ['required', 'in:local,auto'],
            'audio_voice' => ['required', "array:{$languages}"],
            'audio_voice.*' => ['required', 'in:male,female'],
            'audio' => ['nullable', "array:{$languages}"],
            'audio.*' => ['nullable', 'file', 'mimes:mp3,wav,ogg,m4a,aac', 'max:5120'],
            'remove_audio' => ['nullable', "array:{$languages}"],
            'remove_audio.*' => ['nullable', 'boolean'],
        ]);

        $data = collect($validated)->except(['audio_source', 'audio_voice', 'audio', 'remove_audio'])->all();
        $errors = [];

        foreach (Word::AUDIO_LANGUAGES as $language => $columns) {
            $data[$columns['source']] = $validated['audio_source'][$language] ?? Word::AUDIO_SOURCE_AUTO;
            $data[$columns['voice']] = $validated['audio_voice'][$language] ?? Word::AUDIO_VOICE_MALE;

            $willHaveFile = $request->hasFile("audio.{$language}")
                || ($word?->audioPath($language) && ! $request->boolean("remove_audio.{$language}"));

            if ($data['audio_enabled'] && $data[$columns['source']] === Word::AUDIO_SOURCE_LOCAL && ! $willHaveFile) {
                $errors["audio.{$language}"] = "Unggah berkas audio {$columns['label']}, atau pilih Otomatis.";
            }
        }

        if ($errors) {
            throw ValidationException::withMessages($errors);
        }

        return $data;
    }

    private function handleUploads(Request $request, array $data, ?Word $word = null): array
    {
        if ($request->boolean('remove_image') && $word?->image_path) {
            Storage::disk('public')->delete($word->image_path);
            $data['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            if ($word?->image_path) {
                Storage::disk('public')->delete($word->image_path);
            }
            $data['image_path'] = $request->file('image')->store('words/images', 'public');
        }

        foreach (Word::AUDIO_LANGUAGES as $language => $columns) {
            $existingPath = $word?->audioPath($language);

            if ($data[$columns['source']] === Word::AUDIO_SOURCE_AUTO) {
                if ($existingPath) {
                    Storage::disk('public')->delete($existingPath);
                }
                $data[$columns['path']] = null;

                continue;
            }

            if ($request->boolean("remove_audio.{$language}") && $existingPath) {
                Storage::disk('public')->delete($existingPath);
                $data[$columns['path']] = null;
            }

            if ($request->hasFile("audio.{$language}")) {
                if ($existingPath) {
                    Storage::disk('public')->delete($existingPath);
                }
                $data[$columns['path']] = $request->file("audio.{$language}")->store('words/audio', 'public');
            }
        }

        unset($data['image'], $data['remove_image']);

        return $data;
    }
}
