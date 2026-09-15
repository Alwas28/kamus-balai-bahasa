<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Word;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Word>
 */
class WordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'word_id' => $this->faker->unique()->word(),
            'word_konawe' => $this->faker->word(),
            'word_mekongga' => $this->faker->word(),
            'audio_source' => Word::AUDIO_SOURCE_AUTO,
            'audio_voice' => Word::AUDIO_VOICE_MALE,
            'order' => $this->faker->numberBetween(0, 50),
        ];
    }
}
