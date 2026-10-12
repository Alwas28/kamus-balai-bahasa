<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Word extends Model
{
    use HasFactory;

    public const AUDIO_SOURCE_LOCAL = 'local';

    public const AUDIO_SOURCE_AUTO = 'auto';

    public const AUDIO_VOICE_MALE = 'male';

    public const AUDIO_VOICE_FEMALE = 'female';

    /**
     * Audio settings per language: label plus the columns holding its source, TTS voice and uploaded file.
     *
     * @var array<string, array{label: string, source: string, voice: string, path: string}>
     */
    public const AUDIO_LANGUAGES = [
        'id' => ['label' => 'Bahasa Indonesia', 'source' => 'audio_source', 'voice' => 'audio_voice', 'path' => 'audio_path'],
        'konawe' => ['label' => 'Dialek Konawe', 'source' => 'audio_konawe_source', 'voice' => 'audio_konawe_voice', 'path' => 'audio_konawe_path'],
        'mekongga' => ['label' => 'Dialek Mekongga', 'source' => 'audio_mekongga_source', 'voice' => 'audio_mekongga_voice', 'path' => 'audio_mekongga_path'],
    ];

    protected $fillable = [
        'category_id',
        'word_id',
        'word_konawe',
        'word_mekongga',
        'image_path',
        'audio_path',
        'audio_konawe_path',
        'audio_mekongga_path',
        'audio_enabled',
        'audio_source',
        'audio_voice',
        'audio_konawe_source',
        'audio_konawe_voice',
        'audio_mekongga_source',
        'audio_mekongga_voice',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'audio_enabled' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function imageUrl(): ?string
    {
        // Root-relative (not Storage::url()'s absolute APP_URL-based URL) so images still
        // resolve correctly when the app is browsed from a host/port other than APP_URL.
        return $this->image_path ? '/storage/'.$this->image_path : null;
    }

    public function audioSource(string $language = 'id'): string
    {
        return $this->{self::AUDIO_LANGUAGES[$language]['source']} ?? self::AUDIO_SOURCE_AUTO;
    }

    public function audioVoice(string $language = 'id'): string
    {
        return $this->{self::AUDIO_LANGUAGES[$language]['voice']} ?? self::AUDIO_VOICE_MALE;
    }

    public function audioPath(string $language = 'id'): ?string
    {
        return $this->{self::AUDIO_LANGUAGES[$language]['path']};
    }

    public function usesLocalAudio(string $language = 'id'): bool
    {
        return $this->audioSource($language) === self::AUDIO_SOURCE_LOCAL && filled($this->audioPath($language));
    }

    public function audioUrl(string $language = 'id'): ?string
    {
        if (! $this->audio_enabled || ! $this->usesLocalAudio($language)) {
            return null;
        }

        return '/storage/'.$this->audioPath($language);
    }
}
