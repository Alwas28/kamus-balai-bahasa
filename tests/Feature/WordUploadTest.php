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
            'audio_source' => Word::AUDIO_SOURCE_LOCAL,
            'audio_voice' => Word::AUDIO_VOICE_MALE,
            'audio' => UploadedFile::fake()->create('rumah.mp3', 100, 'audio/mpeg'),
        ]);

        $response->assertRedirect(route('admin.words.index'));

        $word = Word::where('word_id', 'rumah')->firstOrFail();

        $this->assertNotNull($word->image_path);
        $this->assertNotNull($word->audio_path);
        $this->assertSame(Word::AUDIO_SOURCE_LOCAL, $word->audio_source);
        Storage::disk('public')->assertExists($word->image_path);
        Storage::disk('public')->assertExists($word->audio_path);
    }

    public function test_creating_a_word_with_automatic_audio_does_not_require_a_file(): void
    {
        Storage::fake('public');

        $user = $this->userWithWordPermissions();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.words.store'), [
            'category_id' => $category->id,
            'word_id' => 'gunung',
            'audio_enabled' => true,
            'audio_source' => Word::AUDIO_SOURCE_AUTO,
            'audio_voice' => Word::AUDIO_VOICE_FEMALE,
        ]);

        $response->assertRedirect(route('admin.words.index'));

        $word = Word::where('word_id', 'gunung')->firstOrFail();

        $this->assertNull($word->audio_path);
        $this->assertSame(Word::AUDIO_SOURCE_AUTO, $word->audio_source);
        $this->assertSame(Word::AUDIO_VOICE_FEMALE, $word->audio_voice);
    }

    public function test_local_audio_source_requires_a_file_when_none_exists_yet(): void
    {
        $user = $this->userWithWordPermissions();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.words.store'), [
            'category_id' => $category->id,
            'word_id' => 'laut',
            'audio_enabled' => true,
            'audio_source' => Word::AUDIO_SOURCE_LOCAL,
            'audio_voice' => Word::AUDIO_VOICE_MALE,
        ]);

        $response->assertSessionHasErrors('audio');
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
            'audio_source' => Word::AUDIO_SOURCE_LOCAL,
            'audio_voice' => Word::AUDIO_VOICE_MALE,
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
            'audio_source' => Word::AUDIO_SOURCE_LOCAL,
            'audio_voice' => Word::AUDIO_VOICE_MALE,
        ]);

        $response->assertRedirect(route('admin.words.index'));

        $word->refresh();
        $this->assertFalse($word->audio_enabled);
        $this->assertNull($word->audioUrl());
        // Toggling off is a soft hide, not a delete: the uploaded file should remain intact.
        Storage::disk('public')->assertExists($word->audio_path);
    }
}
