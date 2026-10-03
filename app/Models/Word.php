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

    protected $fillable = [
        'category_id',
        'word_id',
        'word_konawe',
        'word_mekongga',
        'image_path',
        'audio_path',
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

    public function audioUrl(): ?string
    {
        if (! $this->audio_enabled || $this->audio_source !== self::AUDIO_SOURCE_LOCAL || ! $this->audio_path) {
            return null;
        }

        return '/storage/'.$this->audio_path;
    }
}
