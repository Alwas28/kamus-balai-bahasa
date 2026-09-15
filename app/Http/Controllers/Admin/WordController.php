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
        if ($word->audio_path) {
            Storage::disk('public')->delete($word->audio_path);
        }

        $word->delete();

        return redirect()->route('admin.words.index')->with('status', 'Kosakata berhasil dihapus.');
    }

    private function validated(Request $request, ?Word $word = null): array
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'word_id' => ['required', 'string', 'max:255'],
            'word_konawe' => ['nullable', 'string', 'max:255'],
            'word_mekongga' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
            'remove_image' => ['nullable', 'boolean'],
            'audio_source' => ['required', 'in:local,auto'],
            'audio_voice' => ['required', 'in:male,female'],
            'audio' => ['nullable', 'file', 'mimes:mp3,wav,ogg,m4a,aac', 'max:5120'],
            'remove_audio' => ['nullable', 'boolean'],
        ]);

        $willKeepExistingAudio = $word?->audio_path && ! $request->boolean('remove_audio');

        if ($data['audio_source'] === Word::AUDIO_SOURCE_LOCAL
            && ! $request->hasFile('audio')
            && ! $willKeepExistingAudio) {
            throw ValidationException::withMessages([
                'audio' => 'Unggah berkas audio, atau pilih Audio Otomatis.',
            ]);
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

        if ($data['audio_source'] === Word::AUDIO_SOURCE_AUTO) {
            if ($word?->audio_path) {
                Storage::disk('public')->delete($word->audio_path);
            }
            $data['audio_path'] = null;
        } elseif ($request->boolean('remove_audio') && $word?->audio_path) {
            Storage::disk('public')->delete($word->audio_path);
            $data['audio_path'] = null;
        }

        if ($request->hasFile('audio')) {
            if ($word?->audio_path) {
                Storage::disk('public')->delete($word->audio_path);
            }
            $data['audio_path'] = $request->file('audio')->store('words/audio', 'public');
        }

        unset($data['image'], $data['audio'], $data['remove_image'], $data['remove_audio']);

        return $data;
    }
}
