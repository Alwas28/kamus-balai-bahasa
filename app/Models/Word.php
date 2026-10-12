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
     * Audio language key => column holding that language's uploaded audio file.
     *
     * @var array<string, string>
     */
    public const AUDIO_LANGUAGE_COLUMNS = [
        'id' => 'audio_path',
        'konawe' => 'audio_konawe_path',
        'mekongga' => 'audio_mekongga_path',
    ];

    /**
     * @var array<string, string>
     */
    public const AUDIO_LANGUAGE_LABELS = [
        'id' => 'Bahasa Indonesia',
        'konawe' => 'Dialek Konawe',
        'mekongga' => 'Dialek Mekongga',
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

    public function audioPath(string $language = 'id'): ?string
    {
        return $this->{self::AUDIO_LANGUAGE_COLUMNS[$language]};
    }

    public function hasLocalAudio(): bool
    {
        return collect(self::AUDIO_LANGUAGE_COLUMNS)->contains(fn (string $column) => filled($this->{$column}));
    }

    public function audioUrl(string $language = 'id'): ?string
    {
        $path = $this->audioPath($language);

        if (! $this->audio_enabled || $this->audio_source !== self::AUDIO_SOURCE_LOCAL || ! $path) {
            return null;
        }

        return '/storage/'.$path;
    }
}
