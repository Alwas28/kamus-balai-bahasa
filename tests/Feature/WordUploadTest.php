<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\Word;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class WordUploadTest extends TestCase
{
    use RefreshDatabase;

    private function userWithWordPermissions(): User
    {
        $role = Role::create(['name' => 'Editor', 'slug' => 'editor-test']);

        $role->permissions()->attach([
            Permission::create(['name' => 'Kosakata - Tambah', 'slug' => 'kata.tambah', 'feature' => 'kata', 'action' => 'tambah'])->id,
            Permission::create(['name' => 'Kosakata - Ubah', 'slug' => 'kata.edit', 'feature' => 'kata', 'action' => 'edit'])->id,
            Permission::create(['name' => 'Kosakata - Lihat', 'slug' => 'kata.read', 'feature' => 'kata', 'action' => 'read'])->id,
            Permission::create(['name' => 'Dasbor - Lihat', 'slug' => 'dashboard.read', 'feature' => 'dashboard', 'action' => 'read'])->id,
        ]);

        return User::factory()->create(['role_id' => $role->id]);
    }

    /**
     * Audio settings for every language, defaulting to automatic male voice.
     *
     * @param  array<string, string>  $sources
     * @param  array<string, string>  $voices
     * @return array{audio_source: array<string, string>, audio_voice: array<string, string>}
     */
    private function audioSettings(array $sources = [], array $voices = []): array
    {
        $languages = array_keys(Word::AUDIO_LANGUAGES);

        return [
            'audio_source' => [...array_fill_keys($languages, Word::AUDIO_SOURCE_AUTO), ...$sources],
            'audio_voice' => [...array_fill_keys($languages, Word::AUDIO_VOICE_MALE), ...$voices],
        ];
    }

    public function test_admin_can_upload_image_and_local_audio_when_creating_a_word(): void
    {
        Storage::fake('public');

        $user = $this->userWithWordPermissions();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.words.store'), [
            'category_id' => $category->id,
            'word_id' => 'rumah',
            'word_konawe' => 'laika',
            'word_mekongga' => 'laika',
            'order' => 0,
            'image' => UploadedFile::fake()->image('rumah.jpg'),
            'audio_enabled' => true,
            ...$this->audioSettings(['id' => Word::AUDIO_SOURCE_LOCAL]),
            'audio' => ['id' => UploadedFile::fake()->create('rumah.mp3', 100, 'audio/mpeg')],
        ]);

        $response->assertRedirect(route('admin.words.index'));

        $word = Word::where('word_id', 'rumah')->firstOrFail();

        $this->assertNotNull($word->image_path);
        $this->assertSame(Word::AUDIO_SOURCE_LOCAL, $word->audio_source);
        Storage::disk('public')->assertExists($word->image_path);
        Storage::disk('public')->assertExists($word->audio_path);
    }

    public function test_creating_a_word_with_automatic_audio_does_not_require_a_file(): void
    {
        $user = $this->userWithWordPermissions();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.words.store'), [
            'category_id' => $category->id,
            'word_id' => 'gunung',
            'audio_enabled' => true,
            ...$this->audioSettings(voices: ['id' => Word::AUDIO_VOICE_FEMALE]),
        ]);

        $response->assertRedirect(route('admin.words.index'));

        $word = Word::where('word_id', 'gunung')->firstOrFail();

        $this->assertNull($word->audio_path);
        $this->assertSame(Word::AUDIO_SOURCE_AUTO, $word->audio_source);
        $this->assertSame(Word::AUDIO_VOICE_FEMALE, $word->audio_voice);
    }

    public function test_each_language_can_choose_its_own_audio_source_and_voice(): void
    {
        Storage::fake('public');

        $user = $this->userWithWordPermissions();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.words.store'), [
            'category_id' => $category->id,
            'word_id' => 'air',
            'word_konawe' => 'iwoi',
            'word_mekongga' => 'iwoi',
            'audio_enabled' => true,
            ...$this->audioSettings(
                ['konawe' => Word::AUDIO_SOURCE_LOCAL],
                ['id' => Word::AUDIO_VOICE_FEMALE, 'mekongga' => Word::AUDIO_VOICE_FEMALE],
            ),
            'audio' => ['konawe' => UploadedFile::fake()->create('konawe.mp3', 100, 'audio/mpeg')],
        ]);

        $response->assertRedirect(route('admin.words.index'));

        $word = Word::where('word_id', 'air')->firstOrFail();

        $this->assertSame(Word::AUDIO_SOURCE_AUTO, $word->audioSource('id'));
        $this->assertSame(Word::AUDIO_VOICE_FEMALE, $word->audioVoice('id'));
        $this->assertNull($word->audioUrl('id'));

        $this->assertSame(Word::AUDIO_SOURCE_LOCAL, $word->audioSource('konawe'));
        Storage::disk('public')->assertExists($word->audio_konawe_path);
        $this->assertSame('/storage/'.$word->audio_konawe_path, $word->audioUrl('konawe'));

        $this->assertSame(Word::AUDIO_SOURCE_AUTO, $word->audioSource('mekongga'));
        $this->assertSame(Word::AUDIO_VOICE_FEMALE, $word->audioVoice('mekongga'));
        $this->assertNull($word->audioUrl('mekongga'));
    }

    public function test_local_audio_source_requires_a_file_for_that_language(): void
    {
        $user = $this->userWithWordPermissions();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.words.store'), [
            'category_id' => $category->id,
            'word_id' => 'laut',
            'audio_enabled' => true,
            ...$this->audioSettings(['id' => Word::AUDIO_SOURCE_LOCAL, 'mekongga' => Word::AUDIO_SOURCE_LOCAL]),
            'audio' => ['id' => UploadedFile::fake()->create('laut.mp3', 100, 'audio/mpeg')],
        ]);

        $response->assertSessionHasErrors('audio.mekongga');
        $response->assertSessionDoesntHaveErrors('audio.id');
        $this->assertDatabaseMissing('words', ['word_id' => 'laut']);
    }

    public function test_disabling_audio_skips_the_local_file_requirement(): void
    {
        $user = $this->userWithWordPermissions();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.words.store'), [
            'category_id' => $category->id,
            'word_id' => 'langit',
            'audio_enabled' => false,
            ...$this->audioSettings(['id' => Word::AUDIO_SOURCE_LOCAL]),
        ]);

        $response->assertRedirect(route('admin.words.index'));

        $word = Word::where('word_id', 'langit')->firstOrFail();

        $this->assertFalse($word->audio_enabled);
        $this->assertNull($word->audioUrl());
    }

    public function test_audio_url_is_hidden_when_audio_is_disabled_even_with_an_existing_file(): void
    {
        Storage::fake('public');

        $user = $this->userWithWordPermissions();
        $category = Category::factory()->create();

        $word = Word::factory()->create([
            'category_id' => $category->id,
            'audio_enabled' => true,
            'audio_source' => Word::AUDIO_SOURCE_LOCAL,
            'audio_path' => 'words/audio/existing.mp3',
        ]);
        Storage::disk('public')->put($word->audio_path, 'fake-audio-content');

        $this->assertNotNull($word->audioUrl());

        $response = $this->actingAs($user)->put(route('admin.words.update', $word), [
            'category_id' => $category->id,
            'word_id' => $word->word_id,
            'audio_enabled' => false,
            ...$this->audioSettings(['id' => Word::AUDIO_SOURCE_LOCAL]),
        ]);

        $response->assertRedirect(route('admin.words.index'));

        $word->refresh();
        $this->assertFalse($word->audio_enabled);
        $this->assertNull($word->audioUrl());
        // Toggling off is a soft hide, not a delete: the uploaded file should remain intact.
        Storage::disk('public')->assertExists($word->audio_path);
    }

    public function test_switching_one_language_to_automatic_deletes_only_its_file(): void
    {
        Storage::fake('public');

        $user = $this->userWithWordPermissions();
        $category = Category::factory()->create();

        $word = Word::factory()->create([
            'category_id' => $category->id,
            'audio_enabled' => true,
            'audio_source' => Word::AUDIO_SOURCE_LOCAL,
            'audio_path' => 'words/audio/indonesia.mp3',
            'audio_konawe_source' => Word::AUDIO_SOURCE_LOCAL,
            'audio_konawe_path' => 'words/audio/konawe.mp3',
        ]);
        Storage::disk('public')->put($word->audio_path, 'indonesia');
        Storage::disk('public')->put($word->audio_konawe_path, 'konawe');

        $response = $this->actingAs($user)->put(route('admin.words.update', $word), [
            'category_id' => $category->id,
            'word_id' => $word->word_id,
            'audio_enabled' => true,
            ...$this->audioSettings(['konawe' => Word::AUDIO_SOURCE_LOCAL]),
        ]);

        $response->assertRedirect(route('admin.words.index'));

        $word->refresh();
        $this->assertSame(Word::AUDIO_SOURCE_AUTO, $word->audio_source);
        $this->assertNull($word->audio_path);
        Storage::disk('public')->assertMissing('words/audio/indonesia.mp3');
        $this->assertSame('words/audio/konawe.mp3', $word->audio_konawe_path);
        Storage::disk('public')->assertExists('words/audio/konawe.mp3');
    }
}
